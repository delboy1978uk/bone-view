<?php

namespace Bone\View\Middleware;

use Bone\View\ViewEngineInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LayoutMiddleware implements MiddlewareInterface
{
    /** @var ViewEngineInterface $viewEngine */
    private $viewEngine;

    /** @var string $defaultLayout\ */
    private $defaultLayout;

    /**
     * LayoutMiddleware constructor.
     * @param ViewEngineInterface $viewEngine
     */
    public function __construct(ViewEngineInterface $viewEngine, string $defaultLayout)
    {
        $this->viewEngine = $viewEngine;
        $this->defaultLayout = $defaultLayout;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $layout = $this->defaultLayout;

        if ($response->hasHeader('layout')) {
            $layout = $response->getHeader('layout')[0];
        }

        $response = $response->withoutHeader('header');
        $contentType = $response->getHeader('Content-Type');
        $isHtmlResponse = $response instanceof HtmlResponse;
        $hasHtmlContent = count($contentType) ? strstr($contentType[0], 'text/html') : true;

        if ((!$isHtmlResponse || !$hasHtmlContent || !$layout)) {
            return $response;
        }

        $body = ['content' => $response->getBody()->getContents()];
        $body = $this->viewEngine->render($layout, $body);

        return $this->getResponseWithBodyAndStatus($response, $body, $response->getStatusCode());
    }


    /**
     * @param Response $response
     * @param string $body
     * @param int $status
     * @return ResponseInterface
     */
    private function getResponseWithBodyAndStatus(Response $response, string $body, int $status = 200): ResponseInterface
    {
        $stream = new Stream('php://memory', 'r+');
        $stream->write($body);
        $response = $response->withStatus($status)->withBody($stream);

        return $response;
    }
}