<?php

namespace Asgrim\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;
use Asgrim\Service\PostService;
use Asgrim\Service\SearchWrapper;

class SearchAction
{
    /**
     * @var SearchWrapper
     */
    private $searchWrapper;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @var TemplateRenderer
     */
    private $template;

    /**
     * @param SearchWrapper $searchWrapper
     * @param PostService $postService
     * @param TemplateRenderer $template
     */
    public function __construct(SearchWrapper $searchWrapper, PostService $postService, TemplateRenderer $template)
    {
        $this->searchWrapper = $searchWrapper;
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
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['q']) || '' === trim($queryParams['q'])) {
            return new HtmlResponse($this->template->render('app::search-error'));
        }

        $rawResults = $this->searchWrapper->search($queryParams['q']);

        $posts = [];
        foreach ($rawResults as $rawResult) {
            $posts[] = $this->postService->fetchPostBySlug($rawResult['slug']);
        }

        return new HtmlResponse($this->template->render('app::search-results', [
            'query' => $queryParams['q'],
            'results' => $posts,
        ]));
    }
}
