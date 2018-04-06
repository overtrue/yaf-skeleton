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
 */
class Registry extends Facade
{
    /**
     * 允许的命名空间.
     */
    const NAMESPACES = ['services', 'session', 'setting', 'routing', 'http', 'testing'];

    /**
     * 设定变量.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     */
    public static function set($key, $value)
    {
        $prefix = strstr($key, '.', true);

        if (!in_array($prefix, self::NAMESPACES)) {
            throw new InvalidArgumentException("不合法的命名空间：$prefix");
        }

        return YafRegistry::set($key, $value);
    }

    /**
     * 读取.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return YafRegistry::get($key) ?? $default;
    }
}
