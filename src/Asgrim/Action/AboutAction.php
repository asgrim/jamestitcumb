<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class AboutAction
{
    /**
     * @var TemplateRenderer
     */
    private $template;

    /**
     * @param TemplateRenderer $template
     */
    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return HtmlResponse
     * @throws \InvalidArgumentException
     */
    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        return new HtmlResponse($this->template->render('app::about', []));
    }
}
