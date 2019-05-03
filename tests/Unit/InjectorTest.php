<?php

namespace Yiisoft\Di\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yiisoft\Di\Container;
use Yiisoft\Di\Exceptions\InvalidConfigException;
use Yiisoft\Di\Exceptions\NotFoundException;
use Yiisoft\Di\Injector;
use Yiisoft\Di\Tests\Support\ColorInterface;
use Yiisoft\Di\Tests\Support\EngineInterface;
use Yiisoft\Di\Tests\Support\EngineMarkTwo;

/**
 * InjectorTest contains tests for \Yiisoft\Di\Injector
 */
class InjectorTest extends TestCase
{
    public function testInvoke()
    {
        $container = new Container([
            EngineInterface::class => EngineMarkTwo::class,
        ]);

        $getEngineName = function (EngineInterface $engine) {
            return $engine->getName();
        };

        $injector = new Injector($container);
        $engineName = $injector->invoke($getEngineName);

        $this->assertSame('Mark Two', $engineName);
    }

    public function testMissingRequiredParameter()
    {
        $container = new Container([
            EngineInterface::class => EngineMarkTwo::class,
        ]);

        $getEngineName = function (EngineInterface $engine, $two) {
            return $engine->getName();
        };

        $injector = new Injector($container);

        $this->expectException(InvalidConfigException::class);
        $engineName = $injector->invoke($getEngineName);
    }

    public function testNotFoundException()
    {
        $container = new Container([
            EngineInterface::class => EngineMarkTwo::class,
        ]);

        $getEngineName = function (EngineInterface $engine, ColorInterface $color) {
            return $engine->getName();
        };

        $injector = new Injector($container);

        $this->expectException(NotFoundException::class);
        $engineName = $injector->invoke($getEngineName);
    }
}
