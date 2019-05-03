<?php


namespace Yiisoft\Di\Definitions;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Contracts\Definition;

class CallableDefinition implements Definition
{
    private $method;

    public function __construct(callable $method)
    {
        $this->method = $method;
    }

    /**
     * @param ContainerInterface $container
     * @param array $params
     */
    public function resolve(ContainerInterface $container, array $params = [])
    {
        return $container->getInjector()->invoke($this->method, $params);
    }
}
