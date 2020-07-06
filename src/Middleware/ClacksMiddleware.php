<?php

declare(strict_types=1);

namespace Asgrim\Middleware;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ClacksMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request)->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett');
    }
}
