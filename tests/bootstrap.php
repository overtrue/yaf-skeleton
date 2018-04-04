<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Controller.php.
 *
 * @author  overtrue <i@overtrue.me>
 */
include __DIR__.'/../vendor/autoload.php';
include __DIR__.'/TestCase.php';
include __DIR__.'/AbstractController.php';
include __DIR__.'/Yaconf.php';
include __DIR__.'/Registry.php';
include __DIR__.'/Dispatcher.php';
include __DIR__.'/helpers.php';

date_default_timezone_set('PRC');

define('TESTS_PATH', __DIR__);
define('TESTS_STUBS_PATH', __DIR__.'/stubs');

Yaf\Registry::put('logged_user', ['id' => 123456]);
