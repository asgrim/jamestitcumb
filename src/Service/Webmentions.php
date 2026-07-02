<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Db\WebmentionsRepository;
use DateTimeImmutable;
use Laminas\Diactoros\Request;
use Psl\Json;
use Psl\Type;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Throwable;

use function count;
use function md5;
use function sprintf;
use function urlencode;

/**
 * @psalm-type Mention = array{
 *     'wm-property': string,
 *     'wm-target': string,
 *     url?: string|null,
 *     published?: string|null,
 *     author?: array{name?: string|null, url?: string|null, photo?: string|null}|null,
 *     content?: array{text?: string|null}|null,
 * }
 */
final class Webmentions
{
    public function __construct(
        private WebmentionsRepository $repository,
        private string $token,
        private string $domain,
        private ClientInterface $httpClient,
        private LoggerInterface $logger,
    ) {
    }

    /** @return list<Mention> */
    public function mentionsForUrl(string $postUrl): array
    {
        return $this->repository->findMentionsForUrl($postUrl);
    }

    /**
     * Fetches every mention for the whole domain from webmention.io and upserts
     * each into Postgres. This is the only refresh mechanism now that reads no
     * longer trigger a live fetch - it must be run periodically (e.g. via Heroku
     * Scheduler) to keep webmentions up to date.
     */
    public function refreshFromWebmentionIo(): void
    {
        foreach ($this->fetchAllMentions() as $targetUrl => $mentions) {
            foreach ($mentions as $mention) {
                $published = $mention['published'] ?? null;
                // webmention.io mentions are almost always self-identifying by `url`,
                // but that field is technically optional - fall back to a hash of the
                // mention itself so two url-less mentions on the same post don't
                // collide on the (target_url, source_url) uniqueness constraint.
                $sourceUrl = $mention['url'] ?? sprintf('urn:mention-hash:%s', md5(Json\encode($mention)));

                $this->repository->upsert(
                    $targetUrl,
                    $sourceUrl,
                    $mention['wm-property'],
                    $this->parsePublishedAt($published),
                    $mention,
                );
            }
        }
    }

    private function parsePublishedAt(string|null $published): DateTimeImmutable|null
    {
        if ($published === null) {
            return null;
        }

        try {
            return new DateTimeImmutable($published);
        } catch (Throwable) {
            $this->logger->warning(sprintf('Could not parse webmention published date: %s', $published));

            return null;
        }
    }

    /**
     * Fetch every mention for the whole domain in one paginated sweep, grouped by
     * the specific post URL (`wm-target`) each mention was directed at.
     *
     * @return array<string, list<Mention>>
     */
    private function fetchAllMentions(): array
    {
        if ($this->token === '') {
            $this->logger->warning('No webmention.io token configured; skipping fetch.');

            return [];
        }

        $grouped = [];
        $page    = 0;
        $perPage = 200;

        do {
            $url = sprintf(
                'https://webmention.io/api/mentions.jf2?domain=%s&token=%s&per-page=%d&page=%d',
                urlencode($this->domain),
                urlencode($this->token),
                $perPage,
                $page,
            );

            $response = $this->httpClient->sendRequest(new Request($url, 'GET'));

            $body = Json\typed(
                (string) $response->getBody(),
                Type\shape([
                    'children' => Type\vec(self::mentionType()),
                ], true),
            );

            foreach ($body['children'] as $mention) {
                $grouped[$mention['wm-target']][] = $mention;
            }

            $page++;
        } while (count($body['children']) === $perPage);

        return $grouped;
    }

    /** @return Type\TypeInterface<Mention> */
    public static function mentionType(): Type\TypeInterface
    {
        return Type\shape([
            'wm-property' => Type\string(),
            'wm-target' => Type\string(),
            'url' => Type\optional(Type\nullable(Type\string())),
            'published' => Type\optional(Type\nullable(Type\string())),
            'author' => Type\optional(Type\nullable(Type\shape([
                'name' => Type\optional(Type\nullable(Type\string())),
                'url' => Type\optional(Type\nullable(Type\string())),
                'photo' => Type\optional(Type\nullable(Type\string())),
            ], true))),
            'content' => Type\optional(Type\nullable(Type\shape([
                'text' => Type\optional(Type\nullable(Type\string())),
            ], true))),
        ], true);
    }
}
