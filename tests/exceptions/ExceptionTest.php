<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use App\Exceptions\Exception;

/**
 * Class ExceptionTest.
 *
 * @author overtrue <i@overtrue.me>
 */
class ExceptionTest extends \TestCase
{
    public function testException()
    {
        $e = new Exception('错误消息', -300);

        self::assertSame('错误消息', $e->getMessage());
        self::assertSame(-300, $e->getCode());
    }

    public function testJsonserialize()
    {
        $e = new Exception('错误消息', -400);

        $expected = json_encode([
            'error' => '错误消息',
            'code' => -400,
        ]);

        self::assertSame($expected, json_encode($e));
    }
}
