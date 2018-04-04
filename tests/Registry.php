<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Yaf;

use App\Support\Collection;

/**
 * Registry mock.
 */
class Registry
{
    protected static $collection;

    public static function getCollection()
    {
        return self::$collection ?: self::$collection = Collection::make();
    }

    public static function __callStatic($method, $args)
    {
        return forward_static_call_array([self::getCollection(), $method], $args);
    }
}
