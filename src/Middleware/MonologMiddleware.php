<?php

declare(strict_types=1);

namespace Asgrim\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Throwable;

final class MonologMiddleware implements MiddlewareInterface
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Throwable
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $anything) {
            $this->logger->error($anything->getMessage(), ['exception' => $anything]);

            throw $anything;
        }
    }
}
