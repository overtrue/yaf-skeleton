<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Commands\Traits;

/**
 * trait GitUserTrait.
 *
 * @author overtrue <i@overtrue.me>
 */
trait GitUserTrait
{
    /**
     * @return string
     */
    public function getUsername()
    {
        $username = exec('git config --get user.name');

        if (empty($username)) {
            $username = strstr($this->getEmail(), '@', true);
        }

        return $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        $email = exec('git config --get user.email');

        return $email;
    }
}
