---
title: Quicker Mezzio Applications with "Mini Mezzio"
tags: [php, laminas, mezzio, middleware, mini mezzio]
---

### Introducing [Mini Mezzio](https://github.com/asgrim/mini-mezzio/) : even *quicker* Mezzio applications! (believe it or not...)

I've always wanted setting up a [Mezzio](https://docs.mezzio.dev/) (formerly Zend Expressive) project to be even easier.
For example, at the time of writing, [Slim PHP](https://www.slimframework.com/) homepage has what I think is an
extremely simple usage code block:

```php
<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();
```

Whilst the Mezzio application setup process is actually very simple, it requires using the [Mezzio Skeleton](https://github.com/mezzio/mezzio-skeleton)
application, which encourages the best practices for a future-proofed setup.

There are times when I want to just spin something up even quicker, even something as simple as the Slim example above.
At first, I created a PR to create a "minimal" application factory in [mezzio/mezzio#43](https://github.com/mezzio/mezzio/pull/43).
However, many suggested this would be better as a separate component. Therefore, I present to you, Mini Mezzio:

```bash
$ composer require asgrim/mini-mezzio laminas/laminas-servicemanager mezzio/mezzio-fastroute
```

Then in `public/index.php`:

```php
<?php

declare(strict_types=1);

use Laminas\Diactoros\Response\TextResponse;
use Laminas\ServiceManager\ServiceManager;
use Asgrim\MiniMezzio\AppFactory;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

require __DIR__ . '/../vendor/autoload.php';

$container = new ServiceManager();
$router = new FastRouteRouter();
$app = AppFactory::create($container, $router);
$app->pipe(new RouteMiddleware($router));
$app->pipe(new DispatchMiddleware());
$app->get('/hello-world', new class implements RequestHandlerInterface {
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse('Hello world!');
    }
});
$app->run();
```

This example I feel is *almost* as slimline as the Slim example; it allows you to assume a bunch of defaults, except for
the choice of Router and PSR-11 Container.

If this is something that interests you, please check out the repository, which includes more documentation, and let me
know how you get on:

* [https://github.com/asgrim/mini-mezzio/](https://github.com/asgrim/mini-mezzio/)
