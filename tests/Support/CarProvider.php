<?php


namespace Yiisoft\Di\Tests\Support;

use Yiisoft\Di\Container;
use Yiisoft\Di\Contracts\ServiceProvider;

class CarProvider implements ServiceProvider
{
    public function register(Container $container): void
    {
        $container->set(Car::class, Car::class);
        $container->set(CarFactory::class, CarFactory::class);
    }
}
