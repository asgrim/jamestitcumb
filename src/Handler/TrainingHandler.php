<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use InvalidArgumentException;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class TrainingHandler implements MiddlewareInterface
{
    public function __construct(private UrlHelper $url)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new RedirectResponse($this->url->generate('home'));
    }
}
