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
use Yaf\Registry;

/**
 * Register Container
 *
 * @package App\Services
 */
class Register implements ContainerInterface
{
    /**
     * 允许的命名空间.
     */
    const NAMESPACES = [
        'services',
        'session',
        'setting',
        'routing',
        'http',
        'testing'
    ];

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
        $prefix = strstr($name, '.', true);

        if (!class_exists($name) && !in_array($prefix, self::NAMESPACES)) {
            throw new \InvalidArgumentException("不合法的命名空间：$prefix");
        }

        Registry::set($name, $instance);

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
        return Registry::get($name);
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
        return Registry::has($name);
    }
}