<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use Asgrim\Service\FeedService;
use Asgrim\Service\PostService;
use InvalidArgumentException;
use Laminas\Diactoros\Response as DiactorosResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

use function array_key_exists;

final class FeedHandler implements MiddlewareInterface
{
    public function __construct(private FeedService $feedService, private PostService $postService)
    {
    }

    private function getContentType(string $type): string
    {
        if ($type === 'atom') {
            return 'application/atom+xml';
        }

        return 'application/xml';
    }

    /**
     * {@inheritDoc}
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $outputFormat = $request->getAttribute('format', 'rss');

        if ($outputFormat !== 'rss') {
            throw new InvalidArgumentException('Invalid output format.');
        }

        $query = $request->getQueryParams();
        if (array_key_exists('tag', $query)) {
            $posts       = $this->postService->fetchPostsByTag($query['tag']);
            $titleSuffix = ' [tag: ' . $query['tag'] . ']';
            $linkSuffix  = '?tag=' . $query['tag'];
        } else {
            $posts       = $this->postService->fetchRecentPosts(10);
            $titleSuffix = '';
            $linkSuffix  = '';
        }

        $feed = $this->feedService->createFeed($posts, $titleSuffix, $linkSuffix);

        $response = new DiactorosResponse('php://temp', 200, ['Content-Type' => $this->getContentType($outputFormat)]);
        $response->getBody()->write($feed->export($outputFormat));

        return $response;
    }
}
