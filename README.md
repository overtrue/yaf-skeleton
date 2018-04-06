<h1 align="center">Yaf skeleton</h1>

<p align="center">The Yaf testable skeleton and composer supported.</p>

# Requirement

- PHP >= 7.0
- Yaf >= 3.0

# Installation

1. Update `yaf.ini`:
```init
[yaf]
yaf.use_namespace=1
yaf.use_spl_autoload=1
...
```

2. Create project.

```shell
$ composer create-project overtrue/yaf-skeleton myapp -vvv
```

3. Web server rewrite rules:
   
    #### Apache
    
    ```conf
    #.htaccess
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule .* index.php
    ```
    
    #### Nginx
    
    ```
    server {
      listen 80;
      server_name  myapp.com;
      root   /path/to/myapp;
      index  index.php index.html index.htm;
     
      if (!-e $request_filename) {
        rewrite ^/(.*)  /index.php/$1 last;
      }
    }
    ```
    
    #### Lighttpd
    
    ```
    $HTTP["host"] =~ "(www.)?myapp.com$" {
      url.rewrite = (
         "^/(.+)/?$"  => "/index.php/$1",
      )
    }
    ```


# Application structor

```
├── .scripts                
│   ├── .gitkeep
│   ├── common.sh
│   ├── job_phpcs.sh
│   ├── job_phpmd.sh
│   ├── job_phpunit.sh
│   ├── sami.phar
│   └── sami.php
├── app                     
│   ├── commands                # sora commands (namespace：\App\Commands)
│   ├── controllers             # Yaf Controllers (namespace：\)
│   ├── exceptions              # Exceptions (namespace：\App\Exceptions)
│   ├── facades                 # Service Facades (namespace：\)
│   ├── plugins                 # Yaf plugins (namespace：\)
│   ├── presenters              # Object presenters (namespace：\App\Presenters)
│   ├── services                # Services, the 3rd service bridges (namespace：\App\Services)
│   ├── traits                  # Traits (namespace：\App\Traits)
│   ├── views                   # Template files
│   ├── helpers.php             # Herlpers
│   ├── Bootstrap.php           # Yaf Bootstrap file
├── config
│   ├── application.ini     # Yaf config file
├── public                  # web extrence
│   └── index.php
├── sora                    # The command line tool
├── tests                   # Unit tests
└── vendor                  # 
├── phpunit.xml.dist        # PHPUnit config file
├── .gitignore
├── .php_cs                 # PHP-CS-Fixer config file
├── composer.json            
├── composer.lock            
├── README.md
```


# Controllers


```shell
$ ./sora make:controller Foo_Bar # or：foo_bar/FooBar/FooBarController 
# 
# /www/myapp/app/controllers/Foo/Bar.php Created!
# /www/myapp/tests/controllers/Foo/BarTest.php Created!
```


All controllers are created in the `app/controllers` directory，and test files are also created in the `tests/controllers` directorty.

Of course, you can also create tests independently：

```shell
$ ./sora make:test Foo_Bar # Also supports multiple type controller names
# /www/myapp/tests/controllers/Foo/BarTest.php Created!
```


### The handle() method

The controller entry method is： `handle()`:

```php
<?php


class ExampleController extends BaseController 
{
    public function handle()
    {
        return 'Hello world!';
        // return view('welcome', ['name' => 'MyApp']);
        // return json(['foo' => 'bar']);
        // return redirect('https://easywechat.com');
    }
}

```
   
# Views

The default we are using the template engine [Plates](http://platesphp.com/v3/), Plates is a native PHP template system that’s fast, easy to use and easy to extend.

You can use `view(string $template, array $data)` helper in controller `handle` method as a result.

for example: 

```php
    public function handle()
    {
        $data = [
            'name' => 'overtrue',
            'age' => 28,
        ];

        return view('profile-page', $data);
    }
```

```php
//app/views/profile-page.php:

<h1><?= $name ?></h1>
<p><?= $age ?></p>
```

More usage please read the [Plates Docs](http://platesphp.com/v3/).

# Unit tests

> The difficulty of writing unit tests is inversely proportional to the quality of your code. The higher the code quality, the lower the difficulty of unit testing, so design your code well.

The unit test for creating the controller can be done with the following command：

```shell
$ ./sora make:test Foo_BarController
```

## Write test cases

To create a controller test object, use，you can use the `mock_controller` function:

```php
$controller = mock_controller(Foo_BarController::class);

// Indicates the method to mock, and the protected method is also mockable
$controller = mock_controller(Foo_BarController::class, ['getUsers', 'getApp']); 
```

## Assertion

We have such a controller:

```php
    ...
    public function handle()
    {
        $params = Reuqest::only('uids', 'screen_name', 'trim_status', 'has_extend', 'simplify', 'is_encoded');

        $users = $this->get('main.users.show_batch', $params);

        return $users;
    }
    ...
```

So the test should cover the above three behaviors：

```php
public function testHandle()
{
    $input = [
        'uids' => '2193182644',
        'screen_name' => '安正超',
        'trim_status' => 0,
        'has_extend' => 1,
        'simplify' => 0,
        'is_encoded' => 0,
        'foo' => 'bar', 
    ];

    Request::shouldReceive('only')
            ->with('uids', 'screen_name', 'trim_status', 'has_extend', 'simplify', 'is_encoded')
            ->andReturn($input);

    $controller = mock_controller(Users_Show_BatchController::class, ['get']); // mock the `get` method

    $controller->shouldReceive('get')->with('main.users.show_batch', array_except($_GET, ['foo']))
                                    ->andReturn('foo')
                                    ->once();

    $response = $controller->handle();

    $this->assertSame('foo', $response);
}
```

## Facade Assertion

```php
Request::shouldReceive('get')->with('mid')->andReturn('mock-mid')->once();
Log::shouldReceive('action')->with(48, 'oid', 'ext')->once();
..
```


### Built-in auxiliary assertion methods

```php
$this->shouldAbort($message, $code);
```

They are used to correspond to exceptions thrown by `abort($message, $code);` in the controller

### Some helper methods in test case classes

Mock request method：

```php
$this->method('post');
```

Mock request `uri`：

```php
$this->uri('/foo/bar?uid=12345');
```

Mock config：

```php
$this->config('foo', 'bar');
```

Mock request IP：

```php
$this->ip('127.0.0.1');
```

Mock $_SERVER vars：

```php
$this->server('REQUEST_URI', '/foo/bar');
```

# Docs

- Yaf Docs: http://www.php.net/manual/en/book.yaf.php
- PHPUnit Docs：https://phpunit.de/manual/current/zh_cn/phpunit-book.html
- Mockery Docs: http://docs.mockery.io/en/latest/

# License

MIT