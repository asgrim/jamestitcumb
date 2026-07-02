<?php

declare(strict_types=1);

namespace AsgrimTest\Db;

use Asgrim\Db\DatabaseUrl;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\Db\DatabaseUrl */
final class DatabaseUrlTest extends TestCase
{
    public function testParsesFullUrl(): void
    {
        $dsn = DatabaseUrl::toPdoDsn('postgres://app:secret@postgres:5432/app');

        self::assertSame('pgsql:host=postgres;port=5432;dbname=app', $dsn['dsn']);
        self::assertSame('app', $dsn['user']);
        self::assertSame('secret', $dsn['pass']);
        self::assertSame('app', $dsn['name']);
    }

    public function testDefaultsPortWhenMissing(): void
    {
        $dsn = DatabaseUrl::toPdoDsn('postgres://app:secret@postgres/app');

        self::assertSame('pgsql:host=postgres;port=5432;dbname=app', $dsn['dsn']);
    }

    public function testAppendsSslModeFromQueryString(): void
    {
        $dsn = DatabaseUrl::toPdoDsn('postgres://app:secret@postgres:5432/app?sslmode=require');

        self::assertSame('pgsql:host=postgres;port=5432;dbname=app;sslmode=require', $dsn['dsn']);
    }

    public function testDecodesUrlEncodedCredentials(): void
    {
        $dsn = DatabaseUrl::toPdoDsn('postgres://us%40er:pa%24s@postgres:5432/app');

        self::assertSame('us@er', $dsn['user']);
        self::assertSame('pa$s', $dsn['pass']);
    }

    public function testThrowsOnInvalidUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DatabaseUrl::toPdoDsn('not-a-url');
    }
}
