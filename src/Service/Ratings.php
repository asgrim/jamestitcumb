<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Db\RatingsRepository;
use Asgrim\Value\Talk;
use DateTimeImmutable;
use Laminas\Diactoros\Request;
use Psl\Json;
use Psl\Type;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

use function array_filter;
use function assert;
use function sprintf;
use function strrpos;
use function substr;

class Ratings
{
    public function __construct(
        private RatingsRepository $repository,
        private LoggerInterface $logger,
        private TalkService $talks,
        private ClientInterface $httpClient,
    ) {
    }

    public function updateCachedRatings(bool $rebuildAll = false): void
    {
        $cutoff = $rebuildAll ? null : new DateTimeImmutable('-3 months');

        $joindinEnabledTalks = array_filter(
            $this->talks->getPastTalks(),
            static function (Talk $talk) use ($cutoff): bool {
                return $talk->joindInLink() !== null && ($cutoff === null || $talk->date() >= $cutoff);
            },
        );

        foreach ($joindinEnabledTalks as $talk) {
            $joindinLink = $talk->joindInLink();
            assert($joindinLink !== null);

            $talkId   = substr($joindinLink, strrpos($joindinLink, '/') + 1);
            $response = Json\typed(
                (string) $this->httpClient
                    ->sendRequest(
                        new Request('https://api.joind.in/v2.1/talks/' . $talkId, 'GET'),
                    )
                    ->getBody(),
                Type\shape([
                    'talks' => Type\vec(Type\shape([
                        'average_rating' => Type\int(),
                    ])),
                ]),
            );

            $rating = $response['talks'][0]['average_rating'];

            $this->logger->debug(sprintf('Talk rating %s found for %s', $rating, $joindinLink));

            if ($rating <= 0) {
                $this->logger->debug(sprintf('Filtering out rating %s for talk %s', $rating, $joindinLink));

                continue;
            }

            $this->repository->upsert($joindinLink, $rating);
        }
    }

    public function ratingForTalk(string $talkUrl): string
    {
        $rating = $this->repository->findRatingForTalk($talkUrl);

        if ($rating === null) {
            return '';
        }

        if ($rating > 5 || $rating < 0) {
            $this->logger->warning(sprintf('Rating %d for talk %s was beyond the allowed bounds', $rating, $talkUrl));

            return '';
        }

        /** @noinspection HtmlUnknownTarget */
        return sprintf(
            ' <img class="talk-card__rating" src="/images/ji-ratings/rating-%d.gif" alt="Joind.in rating %d" />',
            $rating,
            $rating,
        );
    }
}
