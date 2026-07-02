<?php

declare(strict_types=1);

namespace AsgrimTest\Db;

use Asgrim\Db\DatabaseUrl;
use Asgrim\Db\WebmentionsRepository;
use DateTimeImmutable;
use PDO;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\Db\WebmentionsRepository */
final class WebmentionsRepositoryTest extends TestCase
{
    private static PDO $pdo;
    private WebmentionsRepository $repository;

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

        self::$pdo->exec('TRUNCATE TABLE webmentions RESTART IDENTITY');
        self::$pdo->exec('TRUNCATE TABLE webmention_sync_state');

        $this->repository = new WebmentionsRepository(self::$pdo);
    }

    public function testFindMentionsForUrlReturnsEmptyArrayWhenNoneExist(): void
    {
        self::assertSame([], $this->repository->findMentionsForUrl('https://www.jamestitcumb.com/posts/a-post'));
    }

    public function testUpsertThenFindReturnsMention(): void
    {
        $this->repository->upsert(
            'https://www.jamestitcumb.com/posts/a-post',
            'https://example.com/reply',
            'in-reply-to',
            new DateTimeImmutable('2026-01-01T12:00:00+00:00'),
            [
                'wm-property' => 'in-reply-to',
                'wm-target' => 'https://www.jamestitcumb.com/posts/a-post',
                'url' => 'https://example.com/reply',
                'published' => '2026-01-01T12:00:00+00:00',
                'author' => ['name' => 'Jane Doe'],
                'content' => ['text' => 'Nice post!'],
            ],
        );

        $mentions = $this->repository->findMentionsForUrl('https://www.jamestitcumb.com/posts/a-post');

        self::assertCount(1, $mentions);
        self::assertSame('in-reply-to', $mentions[0]['wm-property']);
        self::assertSame('Jane Doe', $mentions[0]['author']['name']);
    }

    public function testUpsertTwiceForSameSourceUpdatesRatherThanDuplicates(): void
    {
        $targetUrl = 'https://www.jamestitcumb.com/posts/a-post';
        $sourceUrl = 'https://example.com/reply';

        $this->repository->upsert($targetUrl, $sourceUrl, 'like-of', null, [
            'wm-property' => 'like-of',
            'wm-target' => $targetUrl,
        ]);
        $this->repository->upsert($targetUrl, $sourceUrl, 'repost-of', null, [
            'wm-property' => 'repost-of',
            'wm-target' => $targetUrl,
        ]);

        $mentions = $this->repository->findMentionsForUrl($targetUrl);

        self::assertCount(1, $mentions);
        self::assertSame('repost-of', $mentions[0]['wm-property']);

        $count = self::$pdo->query('SELECT COUNT(*) FROM webmentions')->fetchColumn();
        self::assertSame(1, (int) $count);
    }

    public function testFindMentionsForUrlOnlyReturnsMentionsForThatTarget(): void
    {
        $this->repository->upsert(
            'https://www.jamestitcumb.com/posts/a-post',
            'https://example.com/one',
            'like-of',
            null,
            ['wm-property' => 'like-of', 'wm-target' => 'https://www.jamestitcumb.com/posts/a-post'],
        );
        $this->repository->upsert(
            'https://www.jamestitcumb.com/posts/another-post',
            'https://example.com/two',
            'like-of',
            null,
            ['wm-property' => 'like-of', 'wm-target' => 'https://www.jamestitcumb.com/posts/another-post'],
        );

        self::assertCount(1, $this->repository->findMentionsForUrl('https://www.jamestitcumb.com/posts/a-post'));
        self::assertCount(
            1,
            $this->repository->findMentionsForUrl('https://www.jamestitcumb.com/posts/another-post'),
        );
    }

    public function testGetLastSyncedAtReturnsNullWhenNeverSynced(): void
    {
        self::assertNull($this->repository->getLastSyncedAt());
    }

    public function testMarkSyncedThenGetLastSyncedAtReturnsThatTime(): void
    {
        $when = new DateTimeImmutable('2026-06-01T10:30:00+00:00');

        $this->repository->markSynced($when);

        self::assertEquals($when, $this->repository->getLastSyncedAt());
    }

    public function testMarkSyncedTwiceUpdatesRatherThanDuplicates(): void
    {
        $this->repository->markSynced(new DateTimeImmutable('2026-06-01T10:30:00+00:00'));
        $secondSync = new DateTimeImmutable('2026-06-02T11:00:00+00:00');
        $this->repository->markSynced($secondSync);

        self::assertEquals($secondSync, $this->repository->getLastSyncedAt());

        $count = self::$pdo->query('SELECT COUNT(*) FROM webmention_sync_state')->fetchColumn();
        self::assertSame(1, (int) $count);
    }
}
