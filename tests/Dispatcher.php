<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Yaf;

/**
 * Dispatcher mock.
 */
class Dispatcher
{
    public static function getInstance()
    {
        return new self();
    }

    public function getRequest()
    {
        return $this;
    }

    public function getServer($key)
    {
        return array_get($_SERVER, $key);
    }

    public function getQuery()
    {
        return $_GET;
    }

    public function getPost()
    {
        return $_POST;
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'get';
    }
}
