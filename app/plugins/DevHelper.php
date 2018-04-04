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
 * Class DevHelperPlugin.
 *
 * @author overtrue <i@overtrue.me>
 */
class DevHelperPlugin extends YafPlugin
{
    /**
     * 开发助手.
     *
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function routerStartup(YafRequest $request, YafResponse $response)
    {
        class_exists('Whoops\Run') && $this->registerWhoops();
    }

    /**
     * 注册 Whoops.
     */
    public function registerWhoops()
    {
        $whoops = new \Whoops\Run();

        if ($this->isWantsJson()) {
            $whoops->pushHandler(new \Whoops\Handler\JsonResponseHandler());
        } else {
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
        }

        $whoops->register();
    }

    /**
     * 是否想返回 json.
     *
     * @return bool
     */
    public function isWantsJson()
    {
        return false !== stripos(Request::header('Accept'), 'application/json');
    }
}
