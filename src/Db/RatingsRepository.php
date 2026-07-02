<?php

declare(strict_types=1);

namespace Asgrim\Db;

use PDO;

use function assert;
use function is_int;

class RatingsRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function upsert(string $talkUrl, int $rating): void
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO ratings (talk_url, rating) VALUES (:talk_url, :rating)
             ON CONFLICT (talk_url) DO UPDATE SET rating = EXCLUDED.rating, updated_at = now()',
        );
        $statement->execute([
            'talk_url' => $talkUrl,
            'rating' => $rating,
        ]);
    }

    public function findRatingForTalk(string $talkUrl): int|null
    {
        $statement = $this->pdo->prepare('SELECT rating FROM ratings WHERE talk_url = :talk_url');
        $statement->execute(['talk_url' => $talkUrl]);

        $rating = $statement->fetchColumn();
        assert(is_int($rating) || $rating === false);

        return $rating === false ? null : $rating;
    }
}
