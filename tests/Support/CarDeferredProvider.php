<?php

namespace Yiisoft\Di\Tests\Support;

use Yiisoft\Di\Container;
use Yiisoft\Di\Support\DeferredServiceProvider;

class CarDeferredProvider extends DeferredServiceProvider
{
    public function provides(): array
    {
        return [
            Car::class,
            CarFactory::class,
        ];
    }

    public function register(Container $container): void
    {
        $container->set(Car::class, ['__class' => Car::class]);
        $container->set(CarFactory::class, CarFactory::class);
        $container->set(EngineInterface::class, EngineMarkOne::class);
    }
}
