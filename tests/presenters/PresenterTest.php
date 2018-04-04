<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use App\Presenters\Presenter;

class DommyPresenter extends Presenter
{
    public function present()
    {
        unset($this->data['foo'], $this->data['bar']);
        $this->data['hello'] = 'world';
    }
}

class PresenterTest extends TestCase
{
    public function testPresent()
    {
        $data = [
            'id' => 2193182644,
            'screen_name' => '安正超',
            'foo' => 'FOO',
            'bar' => 'BAR',
            'some' => 'thing',
        ];

        $presenter = new DommyPresenter($data);

        self::assertSame('安正超', $presenter->screen_name);
        self::assertSame('安正超', $presenter['screen_name']);

        $presenter->screen_name = '小超';
        self::assertSame('小超', $presenter->screen_name);

        $presenter['screen_name'] = 'balabala';
        self::assertSame('balabala', $presenter['screen_name']);

        $expect = [
            'id' => 2193182644,
            'screen_name' => '安正超',
            'some' => 'thing',
            'hello' => 'world',
        ];
        $presenter->screen_name = '安正超';
        // toArray
        self::assertSame($expect, $presenter->toArray());
        // json
        self::assertSame($expect, json_decode(json_encode($presenter), true));
    }
}
