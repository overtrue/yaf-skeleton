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
 * class IndexController.
 *
 * @author overtrue <i@overtrue.me>
 */
class IndexController extends BaseController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle()
    {
        $config = config('app');

        return redirect('https://easywechat.com');
    }
}
