<?php


namespace Yiisoft\Di\Tests\Support;

class OptionalInterfaceDependency
{
    public function __construct(EngineInterface $engine = null)
    {
    }
}
