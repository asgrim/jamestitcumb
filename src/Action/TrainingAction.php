<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

final class TrainingAction implements MiddlewareInterface
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

    public function process(Request $request, DelegateInterface $delegate) : HtmlResponse
    {
        return new HtmlResponse($this->template->render('app::training', []));
    }
}
