<?php

declare(strict_types=1);

namespace Bone\View;

use Barnacle\Container;
use Barnacle\RegistrationInterface;
use Bone\Http\Middleware\Stack;
use Bone\Http\MiddlewareAwareInterface;
use Bone\View\Extension\Plates\AlertBox;
use Bone\View\Middleware\ExceptionMiddleware;
use Bone\View\Middleware\LayoutMiddleware;
use Bone\View\ViewEngine;

class ViewPackage implements RegistrationInterface, MiddlewareAwareInterface
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

    public function addMiddleware(Stack $stack, Container $c): void
    {
        $defaultLayout = $c->get('default_layout');
        $errorPages = $c->get('error_pages');
        $viewEngine = $c->get(ViewEngine::class);
        $layoutMiddleware = new LayoutMiddleware($viewEngine, $defaultLayout);
        $exceptionMiddleware = new ExceptionMiddleware($viewEngine, $errorPages);
        $stack->addMiddleWare($layoutMiddleware);
        $stack->addMiddleWare($exceptionMiddleware);
    }


}
