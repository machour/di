<?php


namespace Yiisoft\Di\Traits;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Contracts\Definition;

trait RecursiveResolveTrait
{
    private function recursiveResolve(Definition $reference, ContainerInterface $container)
    {
        while ($reference instanceof Definition) {
            $reference = $reference->resolve($container);
        }
        return $reference;
    }
}
