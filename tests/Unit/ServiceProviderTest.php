<?php

namespace Yiisoft\Di\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yiisoft\Di\Container;
use Yiisoft\Di\Exceptions\NotInstantiableException;
use Yiisoft\Di\Tests\Support\Car;
use Yiisoft\Di\Tests\Support\CarFactory;
use Yiisoft\Di\Tests\Support\CarProvider;

/**
 * Test for {@link Container} and {@link \Yiisoft\Di\Support\ServiceProvider}
 *
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class ServiceProviderTest extends TestCase
{
    public function testAddProviderByClassName()
    {
        $this->ensureProviderRegisterDefinitions(CarProvider::class);
    }

    public function testAddProviderByDefinition()
    {
        $this->ensureProviderRegisterDefinitions([
            '__class' => CarProvider::class,
        ]);
    }

    protected function ensureProviderRegisterDefinitions($provider)
    {
        $container = new Container();

        $this->assertFalse(
            $container->has(Car::class),
            'Container should not have Car registered before service provider added.'
        );
        $this->assertFalse(
            $container->has(CarFactory::class),
            'Container should not have CarFactory registered before service provider added.'
        );

        $container->addProvider($provider);

        // ensure addProvider invoked ServiceProviderInterface::register
        $this->assertTrue(
            $container->has(Car::class),
            'CarProvider should have registered Car once it was added to container.'
        );
        $this->assertTrue(
            $container->has(CarFactory::class),
            'CarProvider should have registered CarFactory once it was added to container.'
        );
    }

    public function testAddProviderRejectDefinitionWithoutClass()
    {
        $this->expectException(NotInstantiableException::class);
        $container = new Container();
        $container->addProvider([
            'property' => 234
        ]);
    }
}
