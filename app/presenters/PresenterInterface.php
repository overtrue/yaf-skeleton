<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Presenters;

use ArrayAccess;
use JsonSerializable;

/**
 * Interface PresenterInterface.
 */
interface PresenterInterface extends JsonSerializable, ArrayAccess
{
    /**
     * 处理展示数据,去除不需要的数据.
     *
     * @return array
     */
    public function present();

    /**
     * 返回数组结构.
     *
     * @return array
     */
    public function toArray();
}
