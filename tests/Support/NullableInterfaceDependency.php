<?php


namespace Yiisoft\Di\Tests\Support;

class NullableInterfaceDependency
{
    public function __construct(?EngineInterface $engine)
    {
    }
}
