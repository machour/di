<?php


namespace Yiisoft\Di\Definitions;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Container;
use Yiisoft\Di\Contracts\Definition;

class ValueDefinition implements Definition
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param Container $container
     */
    public function resolve(ContainerInterface $container, array $params = [])
    {
        return $this->value;
    }

    /**
     * This is used to detect circular reference.
     * If a concrete reference is guaranteed to never be part of such a circle
     * (for example because it references a simple value) NULL should be returned
     * @return string|null A string uniquely identifying a service in the container
     */
    public function getId(): ?string
    {
        return null;
    }
}
