<?php
/**
 * Created by PhpStorm.
 * User: reatang
 * Date: 18/4/10
 * Time: 下午11:29
 */

namespace App\Services;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Yaf\Registry as YafRegister;

/**
 * Register Container
 *
 * @package App\Services
 */
class Register implements ContainerInterface
{
    /**
     * set instance
     *
     * @param $name
     * @param $instance
     *
     * @return $this
     */
    public function set($name, $instance)
    {
        YafRegister::set($name, $instance);

        return $this;
    }

    /**
     * alias name
     *
     * @param $name
     * @param $instance
     *
     * @return Register
     */
    public function alias($name, $instance)
    {
        return $this->set($name, $instance);
    }

    /**
     * get instance
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return YafRegister::get($name);
    }

    /**
     * instance isset
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return YafRegister::has($name);
    }
}