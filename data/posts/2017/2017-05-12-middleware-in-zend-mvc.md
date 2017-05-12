---
title: Using middleware in Zend MVC
tags: [php, zend, mvc, middleware, zf]
---

For over a year, since 2.7, we have had the ability to use a single middleware in a Zend\Mvc-based application (if
you're not familiar, that's basically "Zend Framework" as opposed to "Zend Expressive"). A nice advantage here is you
can make a forward-port path to migrating across to Zend Expressive. Your config might look something like

```php
<?php
declare(strict_types=1);

return [
    'router' => [
        'routes' => [
            'path' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/path',
                    'defaults' => [
                        'middleware' => \App\Actions\FooAction::class,
                    ],
                ],
            ],
        ],
    ],
];
```

The middleware `FooAction` would be a standard middleware (at that time, the http-interop style middlewares were not
supported, but that's changed now as I'll explain):

```php
<?php
declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

final class FooAction
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null) {
        return new JsonResponse([
            // ... some data ...
        ]);
    }
}
```

This change was great, and I did some work for a client who had started using the `MiddlewareListener` to attach a
middleware to a route like this, and saw it in action. Over time I discovered a couple of flaws. Firstly, the matched
route information was unavailable, so if you had a route matcher like `/foo/:slug`, there was no nice way to discover
the value of `slug` from the matched route. So, dutifully I created patch
[#210](https://github.com/zendframework/zend-mvc/pull/210) to resolve this issue, which was accepted and released in
Zend\Mvc 3.0.4 and up.

Before long, I discovered another glaringly obvious problem: you could only ever have a single middleware added here.
If you're familiar with middleware-style applications, this completely defeats the point: you can pipe your middleware
to inject behaviour (such as authentication, error handling etc.) but this was not possible.

So, leveraging the existing functionality of Zend\Stratigility pipes, I heavily refactored the `MiddlewareListener` to
instead create a pipe from the middleware definition from config. I made it backwards compatible in the sense that the
configuration above would still work, but now you can attach multiple middlewares to a route, like so:

```php
<?php
declare(strict_types=1);

return [
    'router' => [
        'routes' => [
            'path' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/path',
                    'defaults' => [
                        'middleware' => [
                            \App\Middleware\ExtractJsonPayload::class,
                            \App\Middleware\StoragelessPsr7Session::class,
                            \App\Middleware\VerifyIdentity::class,
                            \App\Actions\FooAction::class,
                        ],
                    ],
                ],
            ],
        ],
    ],
];
```

This patch recently got merged in [Zend\Mvc 3.1.0](https://github.com/zendframework/zend-mvc/releases/tag/release-3.1.0)
so you can now take advantage of this handy new feature. I also added support for middlewares that implement
`Interop\Http\ServerMiddleware\MiddlewareInterface` too, so you can now write something like:

```php
<?php
declare(strict_types=1);

namespace App\Actions;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

final class FooAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        return new JsonResponse([
            // ... some data ...
        ]);
    }
}
```

*I provide development, consulting and training for Zend Expressive, Zend Framework, Doctrine and more. If
you'd like to discuss your requirements, [get in touch with me](http://jamestitcumb.com/).*
