<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Http;

use App\Services\Http\Traits\InputCastedAccessor;
use Yaf\Dispatcher;

/**
 * Class Request.
 *
 * @author overtrue <i@overtrue.me>
 */
class Request
{
    use InputCastedAccessor;

    /**
     * @var array
     */
    protected $appends = [];

    /**
     * 客户端请求IP.
     *
     * @var string
     */
    protected $clientIp = '';

    /**
     * 获取请求的数据.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->all(), $key, $default);
    }

    /**
     * 检查是否存在请求的数据.
     *
     * @param string $key
     * @param bool   $strict
     *
     * @return mixed
     */
    public function has($key, $strict = false)
    {
        $value = $this->get($key);

        if ($strict) {
            return !is_null($value);
        }

        if (is_array($value)) {
            return !empty($value);
        }

        /*
         * 防止值为 int 0, string '0' 时造成误判，所以使用 strlen() 来判断是否有该请求参数
         *
         * 特殊：0 === strlen(false) === strlen(null) === strlen('')
         *      1 === strlen(0) === strlen('0') === strlen(1)
         *
         * 数字：2 === strlen(12)，3 === strlen(0.2)
         *
         * 其它：5 === strlen('false'), 4 === strlen('true') === strlen('null')
         */
        return strlen($value) > 0;
    }

    /**
     * 获取全部请求参数.
     *
     * @return array
     */
    public function all()
    {
        static $data;

        if (is_null($data) || defined('TESTING')) {
            $this->filter();
            $data = array_merge($_GET, $_POST);
        }

        return array_merge($data, $this->appends);
    }

    /**
     * TODO 未完成.
     *
     * @return [type] [description]
     */
    public function filter()
    {
    }

    /**
     * 获取上传文件.
     *
     * @param string $name
     *
     * @return array
     */
    public function file($name)
    {
        return $_FILES[$name] ?? null;
    }

    /**
     * 判断是否有正常上传文件.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasFile($name)
    {
        return is_uploaded_file($this->file($name));
    }

    /**
     * 没传某个参数或者参数为空.
     *
     * @param string $key
     * @param bool   $strict
     *
     * @return bool
     */
    public function without($key, $strict = false)
    {
        return !$this->has($key, $strict);
    }

    /**
     * 检查参数确认传了并且不空。
     *
     * @param string $key
     *
     * @return bool
     */
    public function filled($key)
    {
        return $this->has($key, false);
    }

    /**
     * 返回 REQUEST_URI (不带 query).
     *
     * @return string
     */
    public function path()
    {
        $uri = $this->server('REQUEST_URI');

        return str_contains($uri, '?') ? strstr($uri, '?', true) : $uri;
    }

    /**
     * 请求 URI.
     *
     * @return string
     */
    public function uri()
    {
        return $this->server('REQUEST_URI');
    }

    /**
     * 获取 $_SERVER 的值
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return string
     */
    public function server($key, $default = null)
    {
        return $_SERVER[$key] ?? $default;
    }

    /**
     * 只获取指定列表的请求数据.
     *
     * @param array ...$keys
     *
     * @return array
     */
    public function only(...$keys)
    {
        return array_only(
            $this->all(),
            is_array($keys[0] ?? null) ? $keys[0] : $keys
        );
    }

    /**
     * 获取指定参数，保证 key 名，不存在时值为 null.
     *
     * @param array ...$keys
     *
     * @return array
     */
    public function keep(...$keys)
    {
        if (is_array($keys[0] ?? null)) {
            $keys = $keys[0];
        }

        return array_merge(array_combine($keys, array_pad([], count($keys), null)), array_only($this->all(), $keys));
    }

    /**
     * 排除指定参数.
     *
     * @param array ...$keys
     *
     * @return array
     */
    public function except(...$keys)
    {
        return array_except(
            $this->all(),
            is_array($keys[0] ?? null) ? $keys[0] : $keys
        );
    }

    /**
     * 返回请求方式：GET/POST/DELETE...
     *
     * @return string
     */
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']) ?? 'GET';
    }

    /**
     * 获取单个请求头.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return string
     */
    public function header(string $key, $default = null)
    {
        return $this->headers()[strtoupper(str_replace('-', '_', $key))] ?? $default;
    }

    /**
     * 获取 headers.
     */
    public function headers()
    {
        $headers = [];
        $contentHeaders = ['CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true];

        if (empty($headers)) {
            foreach ($_SERVER as $key => $value) {
                if (0 === strpos($key, 'HTTP_')) {
                    $headers[substr($key, 5)] = $value;
                } elseif (isset($contentHeaders[$key])) {
                    // CONTENT_* are not prefixed with HTTP_
                    $headers[$key] = $value;
                }
            }
        }

        return $headers;
    }

    /**
     * 获取客户端 IP.
     *
     * @return string
     */
    public function ip()
    {
        if ($this->clientIp) {
            return $this->clientIp;
        }

        $forwardedIp = $this->header('X_FORWARDED_FOR');
        if (!$forwardedIp) {
            return $this->clientIp = $this->server('REMOTE_ADDR');
        }

        /**
         * 取 IP 的方法说明.
         *
         * @see https://en.wikipedia.org/wiki/X-Forwarded-For
         * @see http://distinctplace.com/infrastructure/2014/04/23/story-behind-x-forwarded-for-and-x-real-ip-headers/
         */
        $ips = explode(',', $forwardedIp);
        $ips = array_reverse($ips);
        foreach ($ips as $ip) {
            $ip = trim($ip);
            // IP 不在内网网段上
            if (!starts_with($ip, ['10.', '172.16.', '192.168.'])) {
                return $this->clientIp = $ip;
            }
        }

        return $this->clientIp;
    }

    /**
     * 获取请求时间.
     *
     * @return int
     */
    public function time()
    {
        return $this->server('REQUEST_TIME') ?? time();
    }

    /**
     * 添加自定义的输入.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->appends[$key] = $value;
    }

    /**
     * 平台.
     * 添加多个自定义的输入.
     *
     * @param array $input
     */
    public function merge(array $input)
    {
        $this->appends = array_merge($input);
    }

    /**
     * 获取当前控制器名称.
     *
     * @return string
     */
    public function controller()
    {
        return Dispatcher::getInstance()->getRequest()->getControllerName();
    }

    /**
     * 获取文件流.
     *
     * @return string
     */
    public function raw()
    {
        return file_get_contents('php://input');
    }

    /**
     * 动态转发到 Yaf\Request_Simple.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return forward_static_call_array([Dispatcher::getInstance()->getRequest(), $method], $args);
    }
}
