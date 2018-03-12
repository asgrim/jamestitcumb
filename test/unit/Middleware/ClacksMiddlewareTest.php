<?php
declare(strict_types=1);

namespace AsgrimTest\Middleware;

use Asgrim\Middleware\ClacksMiddleware;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * @covers \Asgrim\Middleware\ClacksMiddleware
 */
final class ClacksMiddlewareTest extends TestCase
{
    public function testClacksHeaderAdded(): void
    {
        $middleware = new ClacksMiddleware();

        $response = $middleware->process(
            new ServerRequest(['']),
            new class implements DelegateInterface {
                public function process(ServerRequestInterface $request)
                {
                    return new Response();
                }
            }
        );

        self::assertTrue($response->hasHeader('X-Clacks-Overhead'));
        self::assertSame('GNU Terry Pratchett', $response->getHeaderLine('X-Clacks-Overhead'));
    }
}
