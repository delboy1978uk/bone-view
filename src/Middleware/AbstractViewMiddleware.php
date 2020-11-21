<?php

namespace Bone\View\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

abstract class AbstractViewMiddleware implements MiddlewareInterface
{
    /**
     * @param ResponseInterface $response
     * @param string $body
     * @param int $status
     * @return ResponseInterface
     */
    protected function getResponseWithBodyAndStatus(ResponseInterface $response, string $body, int $status = 200): ResponseInterface
    {
        $stream = new Stream('php://memory', 'r+');
        $stream->write($body);
        $response = $response->withStatus($status)->withBody($stream);

        return $response;
    }
}