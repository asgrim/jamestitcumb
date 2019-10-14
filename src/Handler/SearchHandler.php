<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use Asgrim\Service\PostService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\Common\Exceptions\TransportException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;
use Zend\View\Model\ViewModel;
use function array_key_exists;
use function trim;

final class SearchHandler implements MiddlewareInterface
{
    /** @var SearchWrapper */
    private $searchWrapper;

    /** @var PostService */
    private $postService;

    /** @var TemplateRenderer */
    private $template;

    public function __construct(SearchWrapper $searchWrapper, PostService $postService, TemplateRenderer $template)
    {
        $this->searchWrapper = $searchWrapper;
        $this->postService   = $postService;
        $this->template      = $template;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        if (! array_key_exists('q', $queryParams) || trim($queryParams['q']) === '') {
            return new HtmlResponse($this->template->render('app::search/no-query'));
        }

        try {
            $rawResults = $this->searchWrapper->search($queryParams['q']);
        } catch (TransportException $transportException) {
            return new HtmlResponse($this->template->render('app::search/unavailable'));
        }

        $posts = [];
        foreach ($rawResults as $rawResult) {
            $posts[] = $this->postService->fetchPostBySlug($rawResult['slug']);
        }

        $layoutModel = new ViewModel([
            'searchQuery' => $queryParams['q'],
        ]);
        $layoutModel->setTemplate('layout/default');

        return new HtmlResponse($this->template->render('app::search/results', [
            'layout' => $layoutModel,
            'query' => $queryParams['q'],
            'results' => $posts,
        ]));
    }
}
