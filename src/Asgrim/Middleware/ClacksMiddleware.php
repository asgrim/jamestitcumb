<?php
declare(strict_types=1);

namespace Asgrim\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ClacksMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        return $delegate->process($request)->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett');
    }
}
