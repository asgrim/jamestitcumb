<?php

namespace Asgrim\Action;

use Asgrim\Service\Exception\PostNotFound;
use Asgrim\Service\PostService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class PostsAction
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

    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return HtmlResponse
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $slug = $request->getAttribute('slug', null);

        try {
            if (null !== $slug) {
                $posts = [$slug => $this->postService->fetchPostBySlug($slug)];
                $posts[$slug]['active'] = true;
                $title = $posts[$slug]['title'];
            } else {
                $posts = $this->postService->fetchRecentPosts();
                $title = 'Recent posts';
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
