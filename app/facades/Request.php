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
 * Class Request.
 *
 * @author overtrue <i@overtrue.me>
 *
 * @method static mixed  get($key, $default = null)
 * @method static bool   has($key, $strict = false)
 * @method static int    int($key, $default = null)
 * @method static bool   bool($key, $toInt = false, $default = null)
 * @method static bool   bool2Int($key, $default = null)
 * @method static int    abs($key, $default = null)
 * @method static array  all()
 * @method static array  file($name)
 * @method static bool   hasFile($name)
 * @method static bool   without($key, $strict = false)
 * @method static bool   filled($key)
 * @method static string path()
 * @method static string uri()
 * @method static string server($key, $default = null)
 * @method static array  only(...$keys)
 * @method static array  keep(...$keys)
 * @method static array  except(...$keys)
 * @method static string method()
 * @method static string header(string $key, $default = null)
 * @method static array  headers()
 * @method static string ip()
 * @method static string from()
 * @method static int    time()
 * @method static string lang()
 * @method static void   set($key, $value)
 * @method static void   merge(array $input)
 * @method static string controller()
 * @method static mixed  ext()
 */
class Request extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return App\Services\Http\Request::class;
    }
}
