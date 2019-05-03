<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Yiisoft\Di\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yiisoft\Di\Reference;
use Yiisoft\Di\Tests\Support\EngineInterface;

/**
 * ReferenceTest contains tests for \Yiisoft\Di\Reference
 */
class ReferenceTest extends TestCase
{
    public function testTo()
    {
        $ref = Reference::to(EngineInterface::class);
        $this->assertInstanceOf(Reference::class, $ref);
        $this->assertSame(EngineInterface::class, $ref->getId());
    }
}
