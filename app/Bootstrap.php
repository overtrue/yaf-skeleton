<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Yaf\Bootstrap_Abstract as YafBootstrap;
use Yaf\Dispatcher;

/**
 * Class Bootstrap.
 *
 * @author overtrue <i@overtrue.me>
 */
class Bootstrap extends YafBootstrap
{
    /**
     * 项目基本初始化操作.
     *
     * @param Dispatcher $dispatcher
     */
    public function _initProject(Dispatcher $dispatcher)
    {
        date_default_timezone_set('PRC');
        $dispatcher->returnResponse(true);
        $dispatcher->disableView();
    }

    /**
     * 注册插件.
     *
     * @param Dispatcher $dispatcher
     */
    public function _initPlugins(Dispatcher $dispatcher)
    {
        if ($this->env() === 'dev') {
            // 只有在 dev 环境下可以在 URL 里模拟产品环境返回值
            if (Request::get('__env') == 'pro') {
                putenv('APP_ENV=pro');
                $dispatcher->registerPlugin(new ExceptionHandlerPlugin());
            } elseif (class_exists('Whoops\Run')) {
                $dispatcher->registerPlugin(new DevHelperPlugin());
            }
        } else {
            $dispatcher->registerPlugin(new ExceptionHandlerPlugin());
        }

        //$dispatcher->registerPlugin(new AnotherPlugin());
        //...
    }

    /**
     * 获取环境.
     *
     * @return string
     */
    public function env()
    {
        return getenv('APP_ENV') ?: 'dev';
    }
}
