<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use App\Exceptions\ErrorException;

class ErrorExceptionTest extends TestCase
{
    public function testGetResponse()
    {
        //default value
        try {
            throw new ErrorException();
        } catch (\Exception $e) {
            self::assertSame('系统错误', $e->getMessage());
            self::assertSame(500, $e->getCode());
        }

        // custom
        try {
            throw new ErrorException('something went wrong.', -222);
        } catch (\Exception $e) {
            self::assertSame('something went wrong.', $e->getMessage());
            self::assertSame(-222, $e->getCode());
        }
    }
}
