<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\FeedService;
use Asgrim\Service\PostService;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response as DiactorosResponse;

final class FeedAction implements MiddlewareInterface
{
    /**
     * @var FeedService
     */
    private $feedService;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @param FeedService $feedService
     * @param PostService $postService
     */
    public function __construct(FeedService $feedService, PostService $postService)
    {
        $this->feedService = $feedService;
        $this->postService = $postService;
    }

    /**
     * @param string $type
     * @return string
     */
    private function getContentType(string $type) : string
    {
        if ($type === 'atom') {
            return 'application/atom+xml';
        }

        return 'application/xml';
    }

    public function process(Request $request, DelegateInterface $delegate) : DiactorosResponse
    {
        $outputFormat = $request->getAttribute('format', 'rss');

        if ($outputFormat !== 'rss') {
            throw new \InvalidArgumentException('Invalid output format.');
        }

        $query = $request->getQueryParams();
        if (array_key_exists('tag', $query)) {
            $posts = $this->postService->fetchPostsByTag($query['tag']);
            $titleSuffix = ' [tag: ' . $query['tag'] . ']';
            $linkSuffix = '?tag=' . $query['tag'];
        } else {
            $posts = $this->postService->fetchRecentPosts(10);
            $titleSuffix = '';
            $linkSuffix = '';
        }

        $feed = $this->feedService->createFeed($posts, $titleSuffix, $linkSuffix);

        $response = new DiactorosResponse('php://temp', 200, ['Content-Type' => $this->getContentType($outputFormat)]);
        $response->getBody()->write($feed->export($outputFormat));
        return $response;
    }
}
