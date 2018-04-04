<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Class Cache.
 *
 * @method static \App\Services\Throttle make(string $key, int $limit, int $time);
 */
class Throttle extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return App\Services\ThrottleFactory::class;
    }
}
