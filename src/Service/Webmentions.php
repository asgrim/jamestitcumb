<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Laminas\Diactoros\Request;
use Psl\Json;
use Psl\Type;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Throwable;

use function count;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function filemtime;
use function json_encode;
use function sprintf;
use function time;
use function urlencode;

use const JSON_THROW_ON_ERROR;
use const LOCK_EX;

/**
 * @psalm-type Mention = array{
 *     'wm-property': string,
 *     'wm-target': string,
 *     url?: string,
 *     published?: string,
 *     author?: array{name?: string, url?: string, photo?: string},
 *     content?: array{text?: string},
 * }
 */
final class Webmentions
{
    public function __construct(
        private string $cacheFile,
        private string $token,
        private string $domain,
        private ClientInterface $httpClient,
        private LoggerInterface $logger,
        private int $ttlSeconds = 1800,
    ) {
    }

    /** @return list<Mention> */
    public function mentionsForUrl(string $postUrl): array
    {
        $mentions = $this->getFreshOrCachedMentions();

        return $mentions[$postUrl] ?? [];
    }

    /**
     * Force a live fetch and cache rewrite, bypassing the TTL check. Not required
     * for correctness (mentionsForUrl() self-refreshes lazily) - this exists purely
     * as a local dev convenience for warming the cache ahead of time.
     */
    public function forceRefresh(): void
    {
        $this->writeCache($this->fetchAllMentions());
    }

    /**
     * Returns mentions grouped by target URL, refreshing from webmention.io if the
     * local cache is stale or missing. Falls back to a stale cache (or an empty
     * result) if the live fetch fails, so a slow/down webmention.io never breaks a
     * page load.
     *
     * @return array<string, list<Mention>>
     */
    private function getFreshOrCachedMentions(): array
    {
        if ($this->isCacheFresh()) {
            $cached = $this->readCache();
            if ($cached !== null) {
                return $cached;
            }
        }

        try {
            $mentions = $this->fetchAllMentions();
            $this->writeCache($mentions);

            return $mentions;
        } catch (Throwable $throwable) {
            $this->logger->warning(sprintf('Failed to refresh webmentions cache: %s', $throwable->getMessage()));

            return $this->readCache() ?? [];
        }
    }

    private function isCacheFresh(): bool
    {
        if (! file_exists($this->cacheFile)) {
            return false;
        }

        $mtime = filemtime($this->cacheFile);

        return $mtime !== false && (time() - $mtime) < $this->ttlSeconds;
    }

    /** @return array<string, list<Mention>>|null */
    private function readCache(): array|null
    {
        if (! file_exists($this->cacheFile)) {
            return null;
        }

        $contents = file_get_contents($this->cacheFile);
        if ($contents === false || $contents === '') {
            return null;
        }

        try {
            return Json\typed($contents, Type\dict(Type\string(), Type\vec($this->mentionType())));
        } catch (Throwable) {
            return null;
        }
    }

    /** @param array<string, list<Mention>> $mentions */
    private function writeCache(array $mentions): void
    {
        file_put_contents($this->cacheFile, json_encode($mentions, JSON_THROW_ON_ERROR), LOCK_EX);
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
                    'children' => Type\vec($this->mentionType()),
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
    private function mentionType(): Type\TypeInterface
    {
        return Type\shape([
            'wm-property' => Type\string(),
            'wm-target' => Type\string(),
            'url' => Type\optional(Type\string()),
            'published' => Type\optional(Type\string()),
            'author' => Type\optional(Type\shape([
                'name' => Type\optional(Type\string()),
                'url' => Type\optional(Type\string()),
                'photo' => Type\optional(Type\string()),
            ], true)),
            'content' => Type\optional(Type\shape([
                'text' => Type\optional(Type\string()),
            ], true)),
        ], true);
    }
}
