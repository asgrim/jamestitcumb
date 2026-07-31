<?php

declare(strict_types=1);

namespace Asgrim\Middleware;

use InvalidArgumentException;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function implode;

final class SecurityHeadersMiddleware implements MiddlewareInterface
{
    private const string CSP_SELF          = "'self'";
    private const string CSP_UNSAFE_INLINE = "'unsafe-inline'";

    private const array CSP_DIRECTIVES = [
        'default-src' => [self::CSP_SELF],
        'script-src' => [
            self::CSP_SELF,
            self::CSP_UNSAFE_INLINE,
            'cdnjs.cloudflare.com',
            'www.googletagmanager.com',
            'www.google-analytics.com',
            'ssl.google-analytics.com',
        ],
        'style-src' => [self::CSP_SELF, self::CSP_UNSAFE_INLINE, 'cdnjs.cloudflare.com'],
        'img-src' => [self::CSP_SELF, 'data:'],
        'font-src' => [self::CSP_SELF, 'cdnjs.cloudflare.com'],
        'connect-src' => [self::CSP_SELF, 'www.google-analytics.com', 'ssl.google-analytics.com'],
    ];

    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    #[Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request)->withHeader('Content-Security-Policy', $this->buildCspHeader());
    }

    private function buildCspHeader(): string
    {
        $directives = [];

        foreach (self::CSP_DIRECTIVES as $directive => $sources) {
            $directives[] = $directive . ' ' . implode(' ', $sources) . ';';
        }

        return implode(' ', $directives);
    }
}
