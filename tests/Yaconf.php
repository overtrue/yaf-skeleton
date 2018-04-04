<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use App\Support\Collection;

/**
 * Yaconf mock.
 */
class Yaconf
{
    protected static $collection;

    public static function getCollection()
    {
        return self::$collection ?: self::$collection = new Collection();
    }

    public static function __callStatic($method, $args)
    {
        return forward_static_call_array([self::getCollection(), $method], $args);
    }
}
