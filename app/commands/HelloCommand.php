<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Commands;

/**
 * Hello command.
 *
 * @author overtrue <i@overtrue.me>
 */
class HelloCommand extends Command
{
    protected $name = 'hello';
    protected $description = '输出 Hello.';

    public function handle()
    {
        $this->info('Hello world!');
    }
}
