<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Test for Controller: BaseController.
 *
 * @author overtrue <i@overtrue.me>
 */
class BaseControllerTest extends TestCase
{
    public function testIndexActionWithClosureResponse()
    {
        $controller = controller('BaseController');

        $controller->shouldReceive('handle')->andReturn(function ($c) {
            return [$c];
        });

        self::assertEquals($controller, $controller->indexAction()[0]);
    }

    public function testHandleWithErrorResponse()
    {
        $controller = controller('BaseController');

        $this->shouldThrowApiError('something went wrong.', 1000);

        $controller->shouldReceive('handle')->andReturn([
            'error' => 'something went wrong.',
            'error_code' => 1000,
        ])
            ->once();

        $controller->indexAction();
    }

    public function testHeader()
    {
        $controller = controller('BaseController');

        $controller->header('foo', 'bar');

        self::assertContains('foo', $controller->getHeaders());
    }

    public function testNormalizeControllerName()
    {
        $controller = controller('BaseController');

        self::assertEquals('FooController', $controller->normalizeControllerName('foo'));
        self::assertEquals('Foo_BarController', $controller->normalizeControllerName('foo_bar'));
        self::assertEquals('Foo_BarController', $controller->normalizeControllerName('foo/bar'));
        self::assertEquals('Foo_Bar_BazController', $controller->normalizeControllerName('foo/bar_baz'));
        self::assertEquals('Foo_BarController', $controller->normalizeControllerName('foo_barController'));
        self::assertEquals('Foo_BarController', $controller->normalizeControllerName('foo/barController'));
    }

    public function testCall()
    {
        $controller = controller('BaseController', ['getRequest', 'getResponse', 'getView']);

        $controller->shouldReceive('getRequest')->andReturn('request')->once();
        $controller->shouldReceive('getResponse')->andReturn('response')->once();
        $controller->shouldReceive('getView')->andReturn('view')->once();

        self::assertEquals('action response', $controller->call('Dummy_Class_For_Base_Call_MethodController'));
    }
}

/**
 * Class Dummy_Class_For_Base_Call_MethodController.
 */
class Dummy_Class_For_Base_Call_MethodController
{
    public function __construct($request, $response, $view)
    {
    }

    public function indexAction()
    {
        return 'action response';
    }
}
