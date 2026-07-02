<?php

declare(strict_types=1);

namespace Asgrim\Db;

use Asgrim\Service\Webmentions;
use DateTimeImmutable;
use PDO;
use Psl\Json;

use function array_map;

/** @psalm-import-type Mention from Webmentions */
class WebmentionsRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    /** @param Mention $payload */
    public function upsert(
        string $targetUrl,
        string $sourceUrl,
        string $wmProperty,
        DateTimeImmutable|null $publishedAt,
        array $payload,
    ): void {
        $statement = $this->pdo->prepare(
            'INSERT INTO webmentions (target_url, source_url, wm_property, published_at, payload)
             VALUES (:target_url, :source_url, :wm_property, :published_at, :payload::jsonb)
             ON CONFLICT (target_url, source_url) DO UPDATE SET
                 wm_property = EXCLUDED.wm_property,
                 published_at = EXCLUDED.published_at,
                 payload = EXCLUDED.payload,
                 fetched_at = now()',
        );
        $statement->execute([
            'target_url' => $targetUrl,
            'source_url' => $sourceUrl,
            'wm_property' => $wmProperty,
            'published_at' => $publishedAt?->format(DateTimeImmutable::ATOM),
            'payload' => Json\encode($payload),
        ]);
    }

    /** @return list<Mention> */
    public function findMentionsForUrl(string $targetUrl): array
    {
        $statement = $this->pdo->prepare(
            'SELECT payload FROM webmentions WHERE target_url = :target_url ORDER BY published_at',
        );
        $statement->execute(['target_url' => $targetUrl]);

        /** @var list<string> $payloads */
        $payloads = $statement->fetchAll(PDO::FETCH_COLUMN);

        return array_map(
            static fn (string $payload): array => Json\typed($payload, Webmentions::mentionType()),
            $payloads,
        );
    }
}
