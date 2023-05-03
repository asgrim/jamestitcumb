<?php

declare(strict_types=1);

namespace AsgrimTest\Middleware;

use Asgrim\Middleware\ClacksMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/** @covers \Asgrim\Middleware\ClacksMiddleware */
final class ClacksMiddlewareTest extends TestCase
{
    public function testClacksHeaderAdded(): void
    {
        $response = (new ClacksMiddleware())->process(
            new ServerRequest(['']),
            new class implements RequestHandlerInterface {
                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    return new Response();
                }
            },
        );

        self::assertTrue($response->hasHeader('X-Clacks-Overhead'));
        self::assertSame('GNU Terry Pratchett', $response->getHeaderLine('X-Clacks-Overhead'));
    }
}
