<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

final class TrainingHandler implements MiddlewareInterface
{
    /** @var TemplateRenderer */
    private $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::training', []));
    }
}
