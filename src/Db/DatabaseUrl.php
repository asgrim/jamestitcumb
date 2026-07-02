<?php

declare(strict_types=1);

namespace Asgrim\Db;

use InvalidArgumentException;

use function is_string;
use function ltrim;
use function parse_str;
use function parse_url;
use function rawurldecode;
use function sprintf;

final class DatabaseUrl
{
    /** @return array{dsn: string, user: string, pass: string, name: string} */
    public static function toPdoDsn(string $url): array
    {
        $parts = parse_url($url);
        if ($parts === false || ! isset($parts['host'], $parts['path'])) {
            throw new InvalidArgumentException(sprintf('Invalid database URL: %s', $url));
        }

        $dbName = ltrim($parts['path'], '/');
        $port   = $parts['port'] ?? 5432;

        $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $parts['host'], $port, $dbName);

        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
            if (isset($query['sslmode']) && is_string($query['sslmode'])) {
                $dsn .= ';sslmode=' . $query['sslmode'];
            }
        }

        return [
            'dsn' => $dsn,
            'user' => isset($parts['user']) ? rawurldecode($parts['user']) : '',
            'pass' => isset($parts['pass']) ? rawurldecode($parts['pass']) : '',
            'name' => $dbName,
        ];
    }
}
