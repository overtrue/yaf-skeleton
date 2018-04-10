<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Yaf\Registry as YafRegistry;

/**
 * class Registry.
 *
 * @method static get(string $name): mixed
 * @method static set(string $name, mixed $instance): mixed
 * @method static has(string $name): bool
 */
class Registry extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'services.register';
    }
}
