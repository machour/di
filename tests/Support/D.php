<?php


namespace Yiisoft\Di\Tests\Support;

class D
{
    public $c;

    public function __construct(C $c)
    {
        $this->c = $c;
    }
}
