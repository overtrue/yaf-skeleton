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
    public function exceptionHandler(Throwable $e, $yafRequest, $yafResponse)
    {
        //需要注意返回的是浏览器展示的异常，还是api展示的异常
        if ($e instanceof JsonSerializable) {
            $response = $e;
        } else {
            $response = api_return($e->getMessage(), $e->getCode());
        }

        send_response($yafResponse, $response, 200);

        $yafResponse->response();
    }
}
