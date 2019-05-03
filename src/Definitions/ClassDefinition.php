<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Yiisoft\Di\Definitions;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Contracts\Definition;
use Yiisoft\Di\Exceptions\InvalidConfigException;

/**
 * Reference points to a class name in the container
 */
class ClassDefinition implements Definition
{
    private $class;

    private $optional;

    /**
     * Constructor.
     * @param string $class the class name
     */
    public function __construct(string $class, bool $optional)
    {
        $this->class = $class;
        $this->optional = $optional;
    }

    public function resolve(ContainerInterface $container, array $params = [])
    {
        try {
            $result = $container->get($this->class);
        } catch (\Throwable $t) {
            if ($this->optional) {
                return null;
            }
            throw $t;
        }

        if (!$result instanceof $this->class) {
            throw new InvalidConfigException('Container returned incorrect type for service ' . $this->class);
        }
        return $result;
    }
}
