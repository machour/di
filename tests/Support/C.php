<?php


namespace Yiisoft\Di\Tests\Support;

class C
{
    public $d;

    public function __construct(D $d)
    {
        $this->d = $d;
    }
}
