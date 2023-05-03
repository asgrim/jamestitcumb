<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Psl\File;
use Psl\Json;
use Psl\Type;
use Psr\Log\LoggerInterface;

use function array_key_exists;
use function sprintf;

class Ratings
{
    /** @param non-empty-string $ratingsCacheFile */
    public function __construct(private string $ratingsCacheFile, private LoggerInterface $logger)
    {
    }

    /** @return array<non-empty-string, array{rating:int,lastUpdated:non-empty-string}> */
    private function fetchCachedRatings(): array
    {
        return Json\typed(
            File\read($this->ratingsCacheFile),
            Type\dict(
                Type\non_empty_string(),
                Type\shape([
                    'rating' => Type\int(),
                    'lastUpdated' => Type\non_empty_string(),
                ]),
            ),
        );
    }

    public function ratingForTalk(string $talkUrl): string
    {
        try {
            $ratings = $this->fetchCachedRatings();
        } catch (File\Exception\NotFoundException) {
            $this->logger->warning(sprintf('Ratings cache file not found at %s', $this->ratingsCacheFile));

            return '';
        }

        if (! array_key_exists($talkUrl, $ratings)) {
            return '';
        }

        $rating = $ratings[$talkUrl]['rating'];

        if ($rating > 5 || $rating < 0) {
            $this->logger->warning(sprintf('Rating %d for talk %s was beyond the allowed bounds', $rating, $talkUrl));

            return '';
        }

        /** @noinspection HtmlUnknownTarget */
        return sprintf(
            ' <img src="/images/ji-ratings/rating-%d.gif" alt="Joind.in rating %d" />',
            $rating,
            $rating,
        );
    }
}
