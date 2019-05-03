<?php

namespace Yiisoft\Di\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Yiisoft\Di\Container;
use Yiisoft\Di\Contracts\Definition;
use Yiisoft\Di\Definitions\ClassDefinition;
use Yiisoft\Di\Exceptions\NotFoundException;
use Yiisoft\Di\Resolvers\ClassNameResolver;
use Yiisoft\Di\Tests\Support\Car;
use Yiisoft\Di\Tests\Support\GearBox;
use Yiisoft\Di\Tests\Support\NullableConcreteDependency;
use Yiisoft\Di\Tests\Support\NullableInterfaceDependency;
use Yiisoft\Di\Tests\Support\OptionalConcreteDependency;
use Yiisoft\Di\Tests\Support\OptionalInterfaceDependency;

class ClassNameResolverTest extends TestCase
{
    public function testResolveConstructor()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(\DateTime::class);

        $this->assertCount(2, $dependencies);
        // Since reflection for built in classes does not get default values.
        $this->assertEquals(null, $dependencies[0]->resolve($container));
        $this->assertEquals(null, $dependencies[1]->resolve($container));
    }

    public function testResolveCarConstructor()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(Car::class);

        $this->assertCount(1, $dependencies);
        $this->assertInstanceOf(ClassDefinition::class, $dependencies[0]);
        $this->expectException(NotFoundException::class);
        $dependencies[0]->resolve($container);
    }

    public function testResolveGearBoxConstructor()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(GearBox::class);
        $this->assertCount(1, $dependencies);
        $this->assertEquals(5, $dependencies[0]->resolve($container));
    }

    public function testOptionalInterfaceDependency()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(OptionalInterfaceDependency::class);
        $this->assertCount(1, $dependencies);
        $this->assertEquals(null, $dependencies[0]->resolve($container));
    }
    public function testNullableInterfaceDependency()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(NullableInterfaceDependency::class);
        $this->assertCount(1, $dependencies);
        $this->assertEquals(null, $dependencies[0]->resolve($container));
    }

    public function testOptionalConcreteDependency()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(OptionalConcreteDependency::class);
        $this->assertCount(1, $dependencies);
        $this->assertEquals(null, $dependencies[0]->resolve($container));
    }
    public function testNullableConcreteDependency()
    {
        $resolver = new ClassNameResolver();
        $container = new Container();
        /** @var Definition[] $dependencies */
        $dependencies = $resolver->resolveConstructor(NullableConcreteDependency::class);
        $this->assertCount(1, $dependencies);
        $this->assertEquals(null, $dependencies[0]->resolve($container));
    }
}
