<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use App\Exceptions\ErrorException;
use App\Services\Http\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Config 类的别名方法.
 *
 * @param string $property
 * @param mixed  $default
 *
 * @return mixed
 */
function config($property, $default = null)
{
    if (is_array($property)) {
        list($key, $value) = $property;

        return Config::set($key, $value);
    }

    return Config::get($property, $default);
}

/**
 * 输出响应内容.
 *
 * @param array|string|ResponseInterface $body
 * @param int                            $status
 * @param array                          $headers
 */
function send_response($body, $status = 200, $headers = [])
{
    if (defined('TESTING')) {
        return;
    }

    $headers = array_merge([
        'content-type' => 'application/json;charset=utf-8',
    ], $headers);

    if (!($body instanceof Response)) {
        $body = new Response($status, $headers, $body);
    }

    $body->send();

    exit;
}

/**
 * 停止并抛出异常.
 *
 * @param string|array $message
 * @param int          $code
 *
 * @throws ErrorException
 */
function abort($message = '系统错误', $code = 500)
{
    if (is_array($message)) {
        $error = $message['error'] ?? false;
        $message = $error && is_string($error) ? $error : '未知错误';
    }

    throw new ErrorException($message, $code);
}

/**
 * 是否的测试环境中.
 *
 * @return bool
 */
function running_unit_tests()
{
    return defined('TESTING') && TESTING;
}

/**
 * 读取 ENV 配置.
 *
 * @param string $name
 *
 * @return mixed
 */
function env($name)
{
    return getenv($name);
}

/**
 * mobile dump and die.
 *
 * @param array ...$args
 */
function mdd(...$args)
{
    ob_start();
    array_map('var_dump', $args);
    $content = html_entity_decode(strip_tags(ob_get_contents()));
    ob_end_clean();
    echo $content;
    exit;
}

/**
 * Debug 日志.
 *
 * @param string $message
 * @param array  $context
 */
function debug($message, $context = [])
{
    \Log::debug($message, $context);
}

/**
 * 获取当前运行环境名称：dev/production.
 *
 * @return string
 */
function environment()
{
    return getenv('APP_ENV') ?: 'dev';
}

/**
 * 是不是开发环境.
 *
 * @return bool
 */
function is_dev()
{
    return environment() == 'dev';
}
