<?php

namespace Bone\View\Middleware;

use Bone\View\ViewEngineInterface;
use Exception;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExceptionMiddleware extends AbstractViewMiddleware implements MiddlewareInterface
{
    /** @var ViewEngineInterface $viewEngine */
    private $viewEngine;

    /** @var array $errorPages\ */
    private $errorPages;

    /**
     * LayoutMiddleware constructor.
     * @param ViewEngineInterface $viewEngine
     */
    public function __construct(ViewEngineInterface $viewEngine, array $errorPages)
    {
        $this->viewEngine = $viewEngine;
        $this->errorPages = $errorPages;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Exception $e) {
            $code = $e->getStatusCode();
            $status = ($code >= 100 && $code < 600) ? $code : 500;
            $layout = array_key_exists($status, $this->errorPages) ? $this->errorPages[$status] : $this->errorPages['exception'];

            $body = $this->viewEngine->render($layout, [
                'message' => $e->getMessage(),
                'code' => $status,
                'trace' => $e->getTrace(),
            ]);

            $response = new HtmlResponse($body, $status);
        }

        return $response;
    }
}