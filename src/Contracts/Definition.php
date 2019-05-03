<?php


namespace Yiisoft\Di\Contracts;

use Psr\Container\ContainerInterface;

/**
 * Interface DefinitionInterface
 * @package Yiisoft\Di\Contracts
 */
interface Definition
{
    /**
     * @param ContainerInterface $container
     * @param array $params constructor params
     * @return mixed|object
     */
    public function resolve(ContainerInterface $container, array $params = []);
}
