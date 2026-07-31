<?php

declare(strict_types=1);

namespace AsgrimTest\Middleware;

use Asgrim\Middleware\SecurityHeadersMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/** @covers \Asgrim\Middleware\SecurityHeadersMiddleware */
final class SecurityHeadersMiddlewareTest extends TestCase
{
    public function testContentSecurityPolicyHeaderAdded(): void
    {
        $response = (new SecurityHeadersMiddleware())->process(
            new ServerRequest(['']),
            new class implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    return new Response();
                }
            },
        );

        self::assertTrue($response->hasHeader('Content-Security-Policy'));

        $csp = $response->getHeaderLine('Content-Security-Policy');

        self::assertStringContainsString("default-src 'self'", $csp);
        self::assertStringContainsString("script-src 'self' 'unsafe-inline' cdnjs.cloudflare.com", $csp);
        self::assertStringContainsString('www.googletagmanager.com', $csp);
        self::assertStringContainsString('www.google-analytics.com', $csp);
        self::assertStringContainsString("style-src 'self' 'unsafe-inline' cdnjs.cloudflare.com", $csp);
    }
}
