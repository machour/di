<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Yiisoft\Di;

use Yiisoft\Di\Definitions\Normalizer;

class Factory extends Container implements FactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($config, array $params = [])
    {
        $definition = Normalizer::normalize($config);

        return $definition->resolve($this, $params);
    }

    public function get($id)
    {
        return $this->build($this->getId($id));
    }
}
