<?php

declare(strict_types=1);

namespace AsgrimTest\Middleware;

use Asgrim\Middleware\ExceptionLoggingMiddleware;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\Test\TestLogger;
use RuntimeException;

/** @covers \Asgrim\Middleware\ExceptionLoggingMiddleware */
final class ExceptionLoggingMiddlewareTest extends TestCase
{
    public function testExceptionsAreLogged(): void
    {
        $logger = new TestLogger();

        try {
            (new ExceptionLoggingMiddleware($logger))->process(
                new ServerRequest(),
                new class implements RequestHandlerInterface {
                    public function handle(ServerRequestInterface $request): ResponseInterface
                    {
                        throw new RuntimeException('oh no');
                    }
                }
            );

            self::fail('Should not have reached here, exception was thrown!');
        } catch (RuntimeException $exception) {
            self::assertTrue($logger->hasErrorThatContains('oh no'));
        }
    }
}
