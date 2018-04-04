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
 * class Config.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @method static bool has(string $name); 检测一个配置是否存在
 * @method static mixed get(string $name, mixed $default = NULL); 获取一个配置, 名字是配置的名字, 一般来说如果你有一个ini文件叫做foo.ini, 那么$name使用foo的话就会获取到这个文件内的所有内容, 以数组形式返回。 default是当配置不存在的时候返回的默认值
 */
class Config extends Facade
{
    /**
     * 转发到 Yaconf.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return forward_static_call_array("Yaconf::$method", $args);
    }
}
