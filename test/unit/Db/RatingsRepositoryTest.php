<?php

declare(strict_types=1);

namespace AsgrimTest\Db;

use Asgrim\Db\DatabaseUrl;
use Asgrim\Db\RatingsRepository;
use PDO;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\Db\RatingsRepository */
final class RatingsRepositoryTest extends TestCase
{
    private static PDO $pdo;
    private RatingsRepository $repository;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $config = require __DIR__ . '/../../../config/autoload/local.php';
        $dsn    = DatabaseUrl::toPdoDsn($config['database']['url']);

        self::$pdo = new PDO($dsn['dsn'], $dsn['user'], $dsn['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        self::$pdo->exec('TRUNCATE TABLE ratings RESTART IDENTITY');

        $this->repository = new RatingsRepository(self::$pdo);
    }

    public function testFindRatingForTalkReturnsNullWhenMissing(): void
    {
        self::assertNull($this->repository->findRatingForTalk('https://joind.in/talk/view/1'));
    }

    public function testUpsertThenFindReturnsRating(): void
    {
        $this->repository->upsert('https://joind.in/talk/view/1', 4);

        self::assertSame(4, $this->repository->findRatingForTalk('https://joind.in/talk/view/1'));
    }

    public function testUpsertTwiceUpdatesRatherThanDuplicates(): void
    {
        $this->repository->upsert('https://joind.in/talk/view/1', 3);
        $this->repository->upsert('https://joind.in/talk/view/1', 5);

        self::assertSame(5, $this->repository->findRatingForTalk('https://joind.in/talk/view/1'));

        $count = self::$pdo->query('SELECT COUNT(*) FROM ratings')->fetchColumn();
        self::assertSame(1, (int) $count);
    }
}
