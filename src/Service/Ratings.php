<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Value\Talk;
use Laminas\Diactoros\Request;
use Psl\File;
use Psl\Json;
use Psl\Type;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

use function array_combine;
use function array_filter;
use function array_key_exists;
use function array_map;
use function assert;
use function sprintf;
use function strrpos;
use function substr;

class Ratings
{
    /** @param non-empty-string $ratingsCacheFile */
    public function __construct(
        private string $ratingsCacheFile,
        private LoggerInterface $logger,
        private TalkService $talks,
        private ClientInterface $httpClient,
    ) {
    }

    public function updateCachedRatings(): void
    {
        $joindinEnabledTalks = array_filter(
            $this->talks->getPastTalks(),
            static function (Talk $talk): bool {
                return $talk->joindInLink() !== null;
            },
        );

        File\write(
            $this->ratingsCacheFile,
            Json\encode(
                array_filter(
                    Type\dict(
                        Type\non_empty_string(),
                        Type\shape([
                            'rating' => Type\int(),
                        ]),
                    )->assert(
                        array_combine(
                            array_map(
                                static function (Talk $talk): string {
                                    $joindinLink = $talk->joindInLink();
                                    assert($joindinLink !== null);

                                    return $joindinLink;
                                },
                                $joindinEnabledTalks,
                            ),
                            array_map(
                                function (Talk $talk): array {
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

                                    return [
                                        'rating' => $response['talks'][0]['average_rating'],
                                    ];
                                },
                                $joindinEnabledTalks,
                            ),
                        ),
                    ),
                    static function (array $item): bool {
                        return $item['rating'] > 0;
                    },
                ),
                true,
            ),
            File\WriteMode::TRUNCATE,
        );
    }

    /** @return array<non-empty-string, array{rating:int}> */
    private function fetchCachedRatings(): array
    {
        return Json\typed(
            File\read($this->ratingsCacheFile),
            Type\dict(
                Type\non_empty_string(),
                Type\shape([
                    'rating' => Type\int(),
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
