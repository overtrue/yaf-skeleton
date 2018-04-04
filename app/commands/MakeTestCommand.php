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

use Symfony\Component\Console\Input\InputArgument;

/**
 * make test command.
 *
 * @author overtrue <i@overtrue.me>
 */
class MakeTestCommand extends Command
{
    use Traits\ControllerNameParserTrait, Traits\GitUserTrait, Traits\TemplateRenderTrait;

    protected $name = 'make:test';
    protected $description = '创建测试文件';
    protected $arguments = [
        ['controller', InputArgument::OPTIONAL, '控制器类名：Users_UpdateController（可以省掉最后的Controller后缀）'],
    ];

    public function handle()
    {
        $controller = $this->formatControllerName($this->argument('controller'));

        $replacements = [
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'controller' => $controller,
        ];

        $file = BASE_PATH.'/tests/controllers/'.str_replace(['_', 'Controller'], ['/', ''], $controller).'Test.php';

        $this->renderAndSave('test', $replacements, $file);

        exec('composer dump');
    }
}
