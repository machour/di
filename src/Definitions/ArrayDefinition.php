<?php

namespace Yiisoft\Di\Definitions;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Contracts\Definition;
use Yiisoft\Di\Exceptions\NotInstantiableException;
use Yiisoft\Di\Resolvers\ClassNameResolver;
use Yiisoft\Di\Reference;

/**
 * Class Resolver builds object by array config.
 * @package Yiisoft\Di
 */
class ArrayDefinition implements Definition
{
    private $config;

    private static $dependencies = [];

    private const CLASS_KEY = '__class';
    private const CONSTRUCT_KEY = '__construct()';

    /**
     * Injector constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getArray(): array
    {
        return $this->config;
    }

    /**
     * @param string $class
     * @return self
     */
    public static function fromClassName(string $class): self
    {
        return new static([self::CLASS_KEY => $class]);
    }

    /**
     * @param ContainerInterface $container
     * @param array $params
     */
    public function resolve(ContainerInterface $container, array $params = [])
    {
        $config = $this->config;

        if (empty($config[self::CLASS_KEY])) {
            throw new NotInstantiableException(var_export($config, true));
        }

        if (!empty($params)) {
            $config[self::CONSTRUCT_KEY] = array_merge($config[self::CONSTRUCT_KEY] ?? [], $params);
        }

        return $this->buildFromArray($container, $config);
    }

    private function buildFromArray(ContainerInterface $container, array $config)
    {
        if (empty($config[self::CLASS_KEY])) {
            throw new NotInstantiableException(var_export($config, true));
        }
        $class = $config[self::CLASS_KEY];
        unset($config[self::CLASS_KEY]);

        $dependencies = $this->getDependencies($class);

        if (isset($config[self::CONSTRUCT_KEY])) {
            foreach (array_values($config[self::CONSTRUCT_KEY]) as $index => $param) {
                if ($param instanceof Definition) {
                    $dependencies[$index] = $param;
                } else {
                    $dependencies[$index] = new ValueDefinition($param);
                }
            }
            unset($config[self::CONSTRUCT_KEY]);
        }

        $resolved = $container->resolveDependencies($dependencies);
        $object = new $class(...$resolved);
        $this->configure($container, $object, $config);

        return $object;
    }

    /**
     * Returns the dependencies of the specified class.
     * @param string $class class name, interface name or alias name
     * @return Definition[] the dependencies of the specified class.
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @internal
     */
    private function getDependencies(string $class): array
    {
        if (!isset($this->dependencies[$class])) {
            // For now use hard coded resolver.
            $resolver = new ClassNameResolver();

            self::$dependencies[$class] = $resolver->resolveConstructor($class);
        }

        return self::$dependencies[$class];
    }

    /**
     * Configures an object with the given configuration.
     * @param ContainerInterface $container
     * @param object $object the object to be configured
     * @param iterable $config property values and methods to call
     * @return object the object itself
     */
    private function configure(ContainerInterface $container, $object, iterable $config)
    {
        foreach ($config as $action => $arguments) {
            if (substr($action, -2) === '()') {
                // method call
                \call_user_func_array([$object, substr($action, 0, -2)], $arguments);
            } else {
                // property
                if ($arguments instanceof Definition) {
                    $arguments = $arguments->resolve($container);
                }
                $object->$action = $arguments;
            }
        }

        return $object;
    }
}
