<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Support\Debug;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class Dumper
{
    /**
     * Dump a value with elegance.
     *
     * @param mixed $value
     */
    public function dump($value)
    {
        $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

        $dumper->dump((new VarCloner())->cloneVar($value));
    }
}
