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
 * Test for Controller: IndexController.
 *
 * @author overtrue <i@overtrue.me>
 */
class IndexControllerTest extends TestCase
{
    public function testHandle()
    {
        $controller = controller('IndexController');

        $response = $controller->handle();

        self::assertSame('It works!', $response);
    }
}
