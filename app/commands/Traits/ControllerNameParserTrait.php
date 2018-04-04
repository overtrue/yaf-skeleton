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
 * trait ControllerNameParserTrait.
 *
 * @author overtrue <i@overtrue.me>
 */
trait ControllerNameParserTrait
{
    /**
     * @param string $controller
     *
     * @return mixed
     */
    protected function formatControllerName($controller)
    {
        $replacements = [
            ' ' => '',
            '/' => ' ',
            '_' => ' ',
            'Controller' => '',
        ];

        $controller = str_replace(array_keys($replacements), $replacements, trim($controller));

        $controller = preg_replace_callback('/([^_\s])([A-Z])/', function ($matches) {
            return $matches[1].' '.$matches[2];
        }, $controller);

        return str_replace(' ', '_', ucwords($controller.'Controller'));
    }
}
