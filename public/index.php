<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use Yaf\Application as YafApplication;
use Yaf\Response\Http;

define('ROOT_PATH', realpath(__DIR__ . '/../'));
define('APP_PATH', realpath(__DIR__ . '/../app'));
define('APP_START', microtime(true));

$app = new YafApplication(ROOT_PATH . '/config/application.ini');

$response = $app->bootstrap()->run();

if ($response instanceof Http) {
    $response->response();
}
