<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use App\Presenters\PresenterInterface;
use Yaf\Controller_Abstract as YafController;

/**
 * class BaseController.
 *
 * @author overtrue <i@overtrue.me>
 */
abstract class BaseController extends YafController
{
    /**
     * Headers.
     *
     * <pre>
     * [
     *    'content-type' => 'application/json;charset=utf-8'
     * ]
     * </pre>
     *
     * @var array
     */
    protected $headers = [];

    /**
     * 主逻辑.
     */
    public function indexAction()
    {
        $response = $this->handle();

        return $this->handleResponse($response);
    }

    /**
     * 业务主逻辑.
     *
     * @return array
     */
    abstract public function handle();

    /**
     * 添加 header.
     *
     * @param string $header
     *
     * @return $this
     */
    public function header($header)
    {
        $this->headers[] = $header;

        return $this;
    }

    /**
     * 获取设置的 headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * 调用其它控制器.
     *
     * @param string $controller
     *
     * @return mixed
     */
    public function call($controller)
    {
        $controller = $this->normalizeControllerName($controller);

        return (new $controller($this->getRequest(), $this->getResponse(), $this->getView()))->indexAction();
    }

    /**
     * 处理响应内容.
     *
     * @param callable|array|string|\Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     */
    protected function handleResponse($response)
    {
        if (is_callable($response)) {
            $response = $response($this);
        }

        if ($response instanceof PresenterInterface) {
            $response = $response->toArray();
        }

        call_user_func(
            is_array($response) ? 'json_response' : 'send_response',
            $this->getResponse(),
            $response,
            200,
            $this->headers
        );

        return $response;
    }

    /**
     * 格式化控制器名称.
     *
     * @param string $controllerName
     *
     * @return string
     */
    public function normalizeControllerName($controllerName)
    {
        $replacements = [
            ' ' => '',
            '/' => ' ',
            '_' => ' ',
            'Controller' => '',
        ];

        $controller = str_replace(array_keys($replacements), $replacements, trim($controllerName));

        $controller = preg_replace_callback('/([^_\s])([A-Z])/', function ($matches) {
            return $matches[1].' '.$matches[2];
        }, $controller);

        return str_replace(' ', '_', ucwords($controller.'Controller'));
    }
}
