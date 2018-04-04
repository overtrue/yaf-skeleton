<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

function controller($name, $methods = [])
{
    if (!stripos($name, 'Controller')) {
        $name .= 'Controller';
    }
    $name = str_replace('/', '_', $name);
    $methods = is_string($methods) ? explode(',', $methods) : $methods;

    return mock_controller($name, $methods);
}

/**
 * 生成一个测试控制器实例.
 *
 * @param string $name    Users_UpdateController
 * @param array  $methods ex: 'post,get', or ['post', 'get']
 *
 * @return \Mockery\MockInterface
 */
function mock_controller($name, $methods = [])
{
    $methods = is_string($methods) ? explode(',', $methods) : $methods;

    return Mockery::mock($name.'['.join(',', $methods).']')->shouldAllowMockingProtectedMethods();
}

/**
 * 创建 trait 的测试替身.
 *
 * @param string $traitClass
 * @param array  $methods
 *
 * @return \Mockery\MockInterface
 */
function mock_trait($traitClass, $methods = [])
{
    $className = 'DummyClassFor'.class_basename($traitClass).uniqid('_');
    eval(<<<TRAIT_CLASS
class $className
{
    use $traitClass;
}
TRAIT_CLASS
    );

    return Mockery::mock($className.'['.join(',', array_merge(get_api_base_methods(), $methods)).']');
}

/**
 * 设置一个类的 property 属性值
 *
 * @param object $object
 * @param string $property
 * @param mixed  $value
 */
function set_property($object, $property, $value)
{
    $reflection = new ReflectionClass($object);
    $reflectionProperty = $reflection->getProperty($property);
    $reflectionProperty->setAccessible(true);

    $reflectionProperty->setValue($object, $value);
}

/**
 * 获取一个类的 property 属性值
 *
 * @param object $object
 * @param string $property
 *
 * @return mixed
 */
function get_property($object, $property)
{
    $reflection = new ReflectionClass($object);
    $property = $reflection->getProperty($property);
    $property->setAccessible(true);

    return $property->getValue($object);
}
