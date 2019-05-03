<?php

namespace Yiisoft\Di\Tests\Support;

/**
 * Class ColorPink
 *
 * @package Yiisoft\Di\Tests\Support
 */
class ColorPink implements ColorInterface
{
    private const COLOR_PINK = 'pink';

    /**
     * @return string
     */
    public function getColor(): string
    {
        return static::COLOR_PINK;
    }
}
