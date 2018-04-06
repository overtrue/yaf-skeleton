<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Yaf\Plugin_Abstract as YafPlugin;
use Yaf\Request_Abstract as YafRequest;
use Yaf\Response_Abstract as YafResponse;

/**
 * Class ExceptionHandlerPlugin.
 *
 * @author overtrue <i@overtrue.me>
 */
class ExceptionHandlerPlugin extends YafPlugin
{
    /**
     * 异常处理.
     *
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function preDispatch(YafRequest $request, YafResponse $response)
    {
        set_exception_handler(function ($e) use ($request, $response) {
            $this->exceptionHandler($e, $request, $response);
        });
    }

    /**
     * 异常处理器.
     *
     * @param Throwable $e
     */
    public function exceptionHandler(Throwable $e, $request, $response)
    {
        if ($e instanceof JsonSerializable) {
            $body = $e;
        } else {
            $body = [
                'error_code' => $e->getCode(),
                'error' => $e->getMessage(),
            ];
        }

        json($body)->setYafResponse($response)->send();
        $response->response();
    }
}
