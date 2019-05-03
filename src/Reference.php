<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Yiisoft\Di;

use Psr\Container\ContainerInterface;
use Yiisoft\Di\Contracts\Definition;
use Yiisoft\Di\Exceptions\InvalidConfigException;

/**
 * Class Reference allows us to define a dependency to a service in the container in another service definition.
 * For example:
 * ```php
 * [
 *    InterfaceA::class => ConcreteA::class,
 *    'alternativeForA' => ConcreteB::class,
 *    Service1::class => [
 *        '__construct()' => [
 *            Reference::to('alternativeForA')
 *        ]
 *    ]
 * ]
 * ```
 */
class Reference implements Definition
{
    private $id;

    private function __construct($id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public static function to(string $id)
    {
        return new self($id);
    }

    /**
     * @param Container $container
     */
    public function resolve(ContainerInterface $container, array $params = [])
    {
        return $container->get($this->id);
    }

    /**
     * Restores class state after using `var_export()`.
     *
     * @param array $state
     * @return self
     * @throws InvalidConfigException when $state property does not contain `id` parameter
     * @see var_export()
     */
    public static function __set_state($state)
    {
        if (!isset($state['id'])) {
            throw new InvalidConfigException(
                'Failed to instantiate class "Reference". Required parameter "id" is missing'
            );
        }

        return new self($state['id']);
    }
}
