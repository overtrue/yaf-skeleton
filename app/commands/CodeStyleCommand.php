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

use Symfony\Component\Process\Process;

/**
 * CodeStyle command.
 *
 * @author overtrue <i@overtrue.me>
 */
class CodeStyleCommand extends Command
{

    protected $name = 'cs';
    protected $description = '检查代码规范.';

    /**
     * CodeStyleCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->ignoreValidationErrors();
    }

    /**
     * @return int|null
     */
    public function handle()
    {
        $phpcs = BASE_PATH.'/vendor/bin/phpcs';

        if (!file_exists($phpcs)) {
            $this->error('请先安装依赖：composer install -vvv');
            return 1;
        }

        $suffix = $this->getCommandLine(true);

        if (empty($suffix)) {
            $suffix = './app';
        }

        $this->checkAndInstallAppStandard($phpcs);

        $commands = [
            "$phpcs --ignore=app/Bootstrap.php,app/Commands/ $suffix",
        ];

        $this->output->write("<info>checking...</info>\n");

        $process = new Process(join(' && ', $commands));

        $exitCode = $process->setTimeout(360)->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (!$exitCode) {
            $this->output->write("<info>Good job!</info>\n");
        }

        return $exitCode;
    }
}
