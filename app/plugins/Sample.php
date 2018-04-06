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
 * Class SamplePlugin
 *
 * @author overtrue <i@overtrue.me>
 */
class SamplePlugin extends YafPlugin
{
    /**
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function routerStartup(YafRequest $request, YafResponse $response)
    {
        /* 在路由之前执行,这个钩子里，你可以做url重写等功能 */
        var_dump('routerStartup');
    }

    /**
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function routerShutdown(YafRequest $request, YafResponse $response)
    {
        /* 路由完成后，在这个钩子里，你可以做登陆检测等功能*/
        var_dump('routerShutdown');
    }

    /**
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function dispatchLoopStartup(YafRequest $request, YafResponse $response)
    {
        var_dump('dispatchLoopStartup');
    }

    /**
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function preDispatch(YafRequest $request, YafResponse $response)
    {
        var_dump('preDispatch');
    }

    /**
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function postDispatch(YafRequest $request, YafResponse $response)
    {
        var_dump('postDispatch');
    }

    /**
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function dispatchLoopShutdown(YafRequest $request, YafResponse $response)
    {
        /* final hook
           in this hook user can do login or implement layout */
        var_dump('dispatchLoopShutdown');
    }
}
