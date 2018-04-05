<?php

/**
 * Created by PhpStorm.
 * User: reatang
 * Date: 18/4/6
 * Time: 上午1:26
 */
class ApiController extends BaseController
{

    public function handle()
    {
        return api_return('ok', 0, [
            'say' => 'hello world'
        ]);
    }
}