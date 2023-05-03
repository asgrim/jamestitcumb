<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use Asgrim\Service\Exception\PostNotFound;
use Asgrim\Service\PostService;
use Asgrim\Value\Post;
use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface as TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_key_exists;

final class PostsHandler implements MiddlewareInterface
{
    public function __construct(private PostService $postService, private TemplateRenderer $template)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $slug = $request->getAttribute('slug', null);

        try {
            if ($slug !== null) {
                /** @var Post[] $posts */
                $posts = [$slug => $this->postService->fetchPostBySlug($slug)];
                $posts[$slug]->enableCommentsForPost();
                $title = $posts[$slug]->title();
            } else {
                $query = $request->getQueryParams();
                if (array_key_exists('tag', $query)) {
                    $posts = $this->postService->fetchPostsByTag($query['tag']);
                    $title = 'Post matching tag: ';
                } else {
                    $posts = $this->postService->fetchRecentPosts();
                    $title = 'Recent posts';
                }
            }

            return new HtmlResponse($this->template->render('app::posts', [
                'posts' => $posts,
                'title' => $title,
            ]));
        } catch (PostNotFound $postNotFound) {
            return new HtmlResponse($this->template->render('app::post-not-found', ['message' => $postNotFound->getMessage()]));
        }
    }
}
