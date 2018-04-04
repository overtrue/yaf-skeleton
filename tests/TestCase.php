<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Class TestCase.
 *
 * @author    overtrue <i@overtrue.me>
 */
class TestCase extends PHPUnitTestCase
{
    protected $changedServerVars = [];

    /**
     * 设置请求方式：GET,POST...
     *
     * @param string $method
     *
     * @return $this
     */
    public function method($method)
    {
        return $this->server('REQUEST_METHOD', $method);
    }

    /**
     * 设置请求URI.
     *
     * @param string $uri
     *
     * @return $this
     */
    public function uri($uri)
    {
        return $this->server('REQUEST_URI', $uri);
    }

    /**
     * 设置 mock config.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function config($key, $value)
    {
        Yaconf::put($key, $value);

        return $this;
    }

    /**
     * 设置期望异常.
     *
     * @param string|array $message
     * @param int          $code
     */
    public function shouldAbort($message = '参数错误', $code = 500)
    {
        if (is_array($message)) {
            $error = $message['error'] ?? false;
            $message = $error && is_string($error) ? $error : '未知错误';

            $errorCode = $message['error_code'] ?? false;
            $code = $errorCode && is_numeric($errorCode) ? $errorCode : 500;
        }

        $this->expectException(\App\Exceptions\ErrorException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode($code);
    }

    /**
     * 设置访问IP.
     *
     * @param string $ip
     *
     * @return string
     */
    public function ip($ip)
    {
        return $this->server('REMOTE_ADDR', $ip);
    }

    /**
     * 设置 SERVER 变量.
     *
     * @param string $key
     * @param string $value
     *
     * @return \TestCase
     */
    public function server($key, $value)
    {
        $this->changedServerVars[$key] = $_SERVER[$key] ?? null;
        $_SERVER[$key] = $value;

        return $this;
    }

    /**
     * 断言平台返回错误信息.
     *
     * @param string $message
     * @param int    $code
     */
    public function shouldThrowApiError(string $message, $code = 500)
    {
        $this->expectException(\App\Exceptions\ApiException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode($code);
    }

    public function setUp()
    {
        parent::setUp();

        Facade::clearResolvedInstances();

        // 设置假的配置目录
        $this->config('system.path.config', __DIR__.'/stubs/config');
    }

    public function tearDown()
    {
        parent::tearDown();

        $_GET = $_POST = $_COOKIES = $_SESSION = $_REQUEST = [];

        foreach (array_keys($this->changedServerVars) as $key) {
            $_SERVER[$key] = $this->changedServerVars[$key];
        }

        unset($_REQUEST['REQUEST_URI'], $_REQUEST['REQUEST_METHOD']);

        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();

        Facade::clearResolvedInstances();
    }
}
