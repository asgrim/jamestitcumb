<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Service\Webmentions;
use Laminas\View\Helper\AbstractHelper;

use function count;
use function htmlspecialchars;
use function in_array;
use function is_string;
use function parse_url;
use function sprintf;

use const ENT_QUOTES;
use const PHP_URL_HOST;

/** @psalm-import-type Mention from Webmentions */
final class RenderWebmentions extends AbstractHelper
{
    private const array FACEPILE_PROPERTIES = ['like-of', 'repost-of', 'bookmark-of'];

    private const string BASE_URL = 'https://www.jamestitcumb.com/posts/';

    /** Cap avatars actually rendered so the row stays bounded on narrow screens no matter how popular a post gets. */
    private const int FACEPILE_AVATAR_LIMIT = 7;

    public function __construct(private Webmentions $webmentions)
    {
    }

    public function __invoke(string $slug): string
    {
        $mentions = $this->webmentions->mentionsForUrl(self::BASE_URL . $slug);

        if (count($mentions) === 0) {
            return '';
        }

        /** @var list<Mention> $facepile */
        $facepile = [];
        /** @var list<Mention> $replies */
        $replies = [];

        foreach ($mentions as $mention) {
            if (in_array($mention['wm-property'], self::FACEPILE_PROPERTIES, true)) {
                $facepile[] = $mention;
            } else {
                $replies[] = $mention;
            }
        }

        $html = '<div class="webmentions">';

        if (count($facepile) > 0) {
            $html .= $this->renderFacepile($facepile);
        }

        foreach ($replies as $reply) {
            $html .= $this->renderReply($reply);
        }

        $html .= '</div>';

        return $html;
    }

    /** @param list<Mention> $facepile */
    private function renderFacepile(array $facepile): string
    {
        $count = count($facepile);

        $avatars = '';
        $shown   = 0;
        foreach ($facepile as $mention) {
            if ($shown >= self::FACEPILE_AVATAR_LIMIT) {
                break;
            }

            $name  = $this->escape($this->displayName($mention));
            $photo = $mention['author']['photo'] ?? '';

            if ($photo === '') {
                continue;
            }

            $avatars .= sprintf(
                '<img src="%s" alt="%s" class="webmention-facepile__avatar" width="28" height="28" loading="lazy">',
                $this->escape($photo),
                $name,
            );
            $shown++;
        }

        if ($count > $shown) {
            $avatars .= sprintf(
                '<span class="webmention-facepile__more" aria-hidden="true">+%d</span>',
                $count - $shown,
            );
        }

        return sprintf(
            '<div class="webmention-facepile"><span class="webmention-facepile__avatars">%s</span>' .
            '<span class="webmention-facepile__count">%d %s liked or shared this</span></div>',
            $avatars,
            $count,
            $count === 1 ? 'person' : 'people',
        );
    }

    /** @param Mention $mention */
    private function renderReply(array $mention): string
    {
        $name    = $this->escape($this->displayName($mention));
        $url     = $this->escape($this->stringOrDefault($mention['url'] ?? null, '#'));
        $photo   = $mention['author']['photo'] ?? '';
        $content = $this->escape($mention['content']['text'] ?? '');

        $avatar = $photo !== ''
            ? sprintf('<img src="%s" alt="" class="webmention-reply__avatar" width="36" height="36" loading="lazy">', $this->escape($photo))
            : '';

        return sprintf(
            '<article class="webmention-reply">%s<div class="webmention-reply__body">' .
            '<p class="webmention-reply__meta"><a href="%s">%s</a></p>' .
            '<p class="webmention-reply__content">%s</p></div></article>',
            $avatar,
            $url,
            $name,
            $content,
        );
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    /**
     * webmention.io sometimes sends an empty string rather than omitting a field
     * entirely (seen live: `"author": {"name": "", "photo": "", "url": ""}` for a
     * source page with no h-card), so a plain `??` fallback isn't enough here.
     */
    private function stringOrDefault(string|null $value, string $default): string
    {
        return $value !== null && $value !== '' ? $value : $default;
    }

    /**
     * Falls back to "{host} mentioned this post" using the mention's source URL
     * when there's no h-card author name (common for sources without proper
     * microformats), rather than an anonymous "Someone".
     *
     * @param Mention $mention
     */
    private function displayName(array $mention): string
    {
        $name = $mention['author']['name'] ?? null;
        if ($name !== null && $name !== '') {
            return $name;
        }

        $url  = $mention['url'] ?? null;
        $host = $url !== null && $url !== '' ? parse_url($url, PHP_URL_HOST) : null;

        return is_string($host) && $host !== '' ? $host . ' mentioned this post' : 'Someone mentioned this post';
    }
}
