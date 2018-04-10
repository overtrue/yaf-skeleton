<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Mockery\MockInterface;
use \App\Services\Register;

/**
 * 外观基类.
 */
abstract class Facade
{
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;

    /**
     * @var Register
     */
    protected static $container;

    /**
     * start Facade
     *
     * @param Register $register
     */
    public static function init(Register $register)
    {
        static::$container = $register;
    }

    /**
     * Hotswap the underlying instance behind the facade.
     *
     * @param mixed $instance
     */
    public static function swap($instance)
    {
        static::$resolvedInstance[static::getFacadeAccessor()] = $instance;
    }

    /**
     * Initiate a mock expectation on the facade.
     *
     * @return \Mockery\Expectation
     */
    public static function shouldReceive()
    {
        $name = static::getFacadeAccessor();

        if (static::isMock()) {
            $mock = static::$resolvedInstance[$name];
        } else {
            $mock = static::createFreshMockInstance($name);
        }

        return call_user_func_array([$mock, 'shouldReceive'], func_get_args());
    }

    /**
     * Create a fresh mock instance for the given class.
     *
     * @param string $name
     *
     * @return \Mockery\Expectation
     */
    protected static function createFreshMockInstance($name)
    {
        static::$resolvedInstance[$name] = $mock = static::createMockByName($name);

        $mock->shouldAllowMockingProtectedMethods();

        return $mock;
    }

    /**
     * Create a fresh mock instance for the given class.
     *
     * @param string $name
     *
     * @return \Mockery\Expectation
     */
    protected static function createMockByName($name)
    {
        if (!class_exists($name)) {
            $class = static::getMockableClass($name);
        } else {
            $class = $name;
        }

        return $class ? Mockery::mock($class) : Mockery::mock();
    }

    /**
     * Determines whether a mock is set as the instance of the facade.
     *
     * @return bool
     */
    protected static function isMock()
    {
        $name = static::getFacadeAccessor();

        return isset(static::$resolvedInstance[$name]) &&
               static::$resolvedInstance[$name] instanceof MockInterface;
    }

    /**
     * Get the mockable class for the bound instance.
     *
     * @return string
     */
    protected static function getMockableClass()
    {
        return ($root = static::getFacadeRoot()) ? get_class($root) : null;
    }

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param string|object $name
     *
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (static::$container->has($name)) {
            return static::$container->get($name);
        }

        return static::$resolvedInstance[$name] = new $name();
    }

    /**
     * Clear a resolved facade instance.
     *
     * @param string $name
     */
    public static function clearResolvedInstance($name)
    {
        unset(static::$resolvedInstance[$name]);
    }

    /**
     * Clear all of the resolved instances.
     */
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = [];
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array  $args
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }

    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('请实现 getFacadeAccessor 方法');
    }
}
