<?php

namespace Bone\View\Middleware;

use Bone\Http\Response;
use Bone\Http\Response\LayoutResponse;
use Bone\Server\SiteConfig;
use Bone\View\ViewEngineInterface;
use Bone\Http\Response\HtmlResponse;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LayoutMiddleware implements MiddlewareInterface
{
    /** @var ViewEngineInterface $viewEngine */
    private $viewEngine;

    /** @var string $defaultLayout \ */
    private $defaultLayout;

    /** @var SiteConfig $config \ */
    private $config;

    /**
     * LayoutMiddleware constructor.
     * @param ViewEngineInterface $viewEngine
     * @param string $defaultLayout
     * @param SiteConfig $config
     */
    public function __construct(ViewEngineInterface $viewEngine, string $defaultLayout, SiteConfig $config)
    {
        $this->viewEngine = $viewEngine;
        $this->defaultLayout = $defaultLayout;
        $this->config = $config;
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

        if ($response instanceof LayoutResponse) {
            $layout = $response->getLayout();
        } elseif ($response->hasHeader('layout')) {
            $layout = $response->getHeader('layout')[0];
            $layout = $layout === 'none' ? false : $layout;
            $response = $response->withoutHeader('header');
        }

        $contentType = $response->getHeader('Content-Type');
        $isHtmlResponse = $response instanceof HtmlResponse || get_class($response) === 'Laminas\Diactoros\Response\HtmlResponse';
        $hasHtmlContent = count($contentType) ? strstr($contentType[0], 'text/html') : true;

        if ((!$isHtmlResponse || !$hasHtmlContent || !$layout)) {
            return $response;
        }

        $body = [
            'content' => $response->getBody()->getContents(),
            'config' => $this->config,
            'user' => null,
            'vars' => [],
        ];

        if ($response instanceof Response) {

            if ($response->hasAttribute('user')) {
                $body['user'] = $response->getAttribute('user');
            }

            if ($response->hasAttribute('vars')) {
                $body['vars'] = $response->getAttribute('vars');
            }

        }

        $body = $this->viewEngine->render($layout, $body);

        return $this->getResponseWithBodyAndStatus($response, $body, $response->getStatusCode());
    }


    /**
     * @param ResponseInterface $response
     * @param string $body
     * @param int $status
     * @return ResponseInterface
     */
    private function getResponseWithBodyAndStatus(ResponseInterface $response, string $body, int $status = 200): ResponseInterface
    {
        $stream = new Stream('php://memory', 'r+');
        $stream->write($body);
        $response = $response->withStatus($status)->withBody($stream);

        return $response;
    }
}