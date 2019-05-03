<?php


namespace Yiisoft\Di\Tests\Support;

class OptionalConcreteDependency
{
    public function __construct(Car $car = null)
    {
    }
}
