<?php
use Yaf\Plugin_Abstract as YafPlugin;
use Yaf\Request_Abstract as YafRequest;
use Yaf\Response_Abstract as YafResponse;

/**
 * Created by PhpStorm.
 * User: reatang
 * Date: 18/4/6
 * Time: 上午1:16
 */
/* plugin class should be placed under ./application/plugins/ */

class SamplePlugin extends YafPlugin
{
    public function routerStartup(YafRequest $request, YafResponse $response)
    {
        /* 在路由之前执行,这个钩子里，你可以做url重写等功能 */
        var_dump("routerStartup");
    }

    public function routerShutdown(YafRequest $request, YafResponse $response)
    {
        /* 路由完成后，在这个钩子里，你可以做登陆检测等功能*/
        var_dump("routerShutdown");
    }

    public function dispatchLoopStartup(YafRequest $request, YafResponse $response)
    {
        var_dump("dispatchLoopStartup");
    }

    public function preDispatch(YafRequest $request, YafResponse $response)
    {
        var_dump("preDispatch");
    }

    public function postDispatch(YafRequest $request, YafResponse $response)
    {
        var_dump("postDispatch");
    }

    public function dispatchLoopShutdown(YafRequest $request, YafResponse $response)
    {
        /* final hoook
           in this hook user can do loging or implement layout */
        var_dump("dispatchLoopShutdown");
    }
}