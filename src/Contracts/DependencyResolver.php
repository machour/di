<?php


namespace Yiisoft\Di\Contracts;

use Yiisoft\Di\Exceptions\NotInstantiableException;

/**
 * Interface DependencyResolverInterface
 *
 * @package Yiisoft\Di\Contracts
 */
interface DependencyResolver
{
    /**
     *
     * @return Definition[] An array of direct dependencies of $class.
     * @throws NotInstantiableException If the class is not instantiable this MUST throw a NotInstantiableException
     */
    public function resolveConstructor(string $class): array;

    /**
     * @param callable $callable
     * @return Definition[] An array of direct dependencies of the callable.
     */
    public function resolveCallable(callable $callable): array;
}
