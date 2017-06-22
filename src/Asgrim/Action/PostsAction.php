<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\Exception\PostNotFound;
use Asgrim\Service\PostService;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

final class PostsAction implements MiddlewareInterface
{
    /**
     * @var PostService
     */
    private $postService;

    /**
     * @var TemplateRenderer
     */
    private $template;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService, TemplateRenderer $template)
    {
        $this->postService = $postService;
        $this->template = $template;
    }

    public function process(Request $request, DelegateInterface $delegate) : HtmlResponse
    {
        $slug = $request->getAttribute('slug', null);

        try {
            if (null !== $slug) {
                $posts = [$slug => $this->postService->fetchPostBySlug($slug)];
                $posts[$slug]['active'] = true;
                $title = $posts[$slug]['title'];
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
