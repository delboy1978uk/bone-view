<?php

declare(strict_types=1);

namespace Bone\View;

use Barnacle\Container;
use Barnacle\RegistrationInterface;
use Bone\Http\GlobalMiddlewareRegistrationInterface;
use Bone\Http\Middleware\Stack;
use Bone\View\Extension\Plates\AlertBox;
use Bone\View\Middleware\ExceptionMiddleware;
use Bone\View\Middleware\LayoutMiddleware;
use Bone\View\ViewEngine;

class ViewPackage implements RegistrationInterface, GlobalMiddlewareRegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        // set up the view engine dependencies
        $viewEngine = new ViewEngine();
        $viewEngine->loadExtension(new AlertBox());
        $c[ViewEngine::class] = $viewEngine;
    }

    /**
     * @param Container $container
     * @return array
     */
    public function getMiddleware(Container $c): array
    {
        $defaultLayout = $c->get('default_layout');
        $errorPages = $c->get('error_pages');
        $viewEngine = $c->get(ViewEngine::class);
        $layoutMiddleware = new LayoutMiddleware($viewEngine, $defaultLayout);
        $exceptionMiddleware = new ExceptionMiddleware($viewEngine, $errorPages);

        return [
            $layoutMiddleware,
            $exceptionMiddleware,
        ];
    }

    /**
     * @param Container $c
     * @return array
     */
    public function getGlobalMiddleware(Container $c): array
    {
        return [
            LayoutMiddleware::class,
            ExceptionMiddleware::class
        ];
    }
}
