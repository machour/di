<?php

namespace Yiisoft\Di\Tests\Support;

use Yiisoft\Di\Initiable;

/**
 * A gear box.
 */
class GearBox implements Initiable
{
    private $maxGear;

    /**
     * @var bool
     */
    private $inited = false;

    public function __construct(int $maxGear = 5)
    {
        $this->maxGear = $maxGear;
    }

    public function init(): void
    {
        $this->inited = true;
    }

    /**
     * @return bool
     */
    public function getInited(): bool
    {
        return $this->inited;
    }
}
