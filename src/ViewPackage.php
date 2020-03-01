<?php

declare(strict_types=1);

namespace Bone\View;

use Barnacle\Container;
use Barnacle\RegistrationInterface;
use Bone\Mvc\Router\Decorator\ExceptionDecorator;
use Bone\Mvc\Router\Decorator\NotAllowedDecorator;
use Bone\Mvc\Router\Decorator\NotFoundDecorator;
use Bone\Mvc\Router\PlatesStrategy;
use Bone\Mvc\View\Extension\Plates\AlertBox;
use Bone\Mvc\View\PlatesEngine;

class ViewPackage implements RegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        // set up the view engine dependencies
        $viewEngine = new PlatesEngine($c->get('viewFolder'));
        $viewEngine->loadExtension(new AlertBox());

        $c[PlatesEngine::class] = $viewEngine;

        $c[NotFoundDecorator::class] = $c->factory(function (Container $c) {
            $layout = $c->get('default_layout');
            $templates = $c->get('error_pages');
            $viewEngine = $c->get(PlatesEngine::class);
            $notFoundDecorator = new NotFoundDecorator($viewEngine, $templates);
            $notFoundDecorator->setLayout($layout);

            return $notFoundDecorator;
        });

        $c[NotAllowedDecorator::class] = $c->factory(function (Container $c) {
            $layout = $c->get('default_layout');
            $templates = $c->get('error_pages');
            $viewEngine = $c->get(PlatesEngine::class);
            $notAllowedDecorator = new NotAllowedDecorator($viewEngine, $templates);
            $notAllowedDecorator->setLayout($layout);

            return $notAllowedDecorator;
        });

        $c[ExceptionDecorator::class] = $c->factory(function (Container $c) {
            $viewEngine = $c->get(PlatesEngine::class);
            $layout = $c->get('default_layout');
            $templates = $c->get('error_pages');
            $decorator = new ExceptionDecorator($viewEngine, $templates);
            $decorator->setLayout($layout);

            return $decorator;
        });

        $c[PlatesStrategy::class] = $c->factory(function (Container $c) {
            $viewEngine = $c->get(PlatesEngine::class);
            $notFoundDecorator = $c->get(NotFoundDecorator::class);
            $notAllowedDecorator = $c->get(NotAllowedDecorator::class);
            $exceptionDecorator = $c->get(ExceptionDecorator::class);
            $layout = $c->get('default_layout');
            $strategy = new PlatesStrategy($viewEngine, $notFoundDecorator, $notAllowedDecorator, $layout, $exceptionDecorator);

            return $strategy;
        });

        /** @var PlatesStrategy $strategy */
        $strategy = $c->get(PlatesStrategy::class);
        $strategy->setContainer($c);

        $this->router->setStrategy($strategy);
    }

    /**
     * @return string
     */
    public function getEntityPath(): string
    {
        return '';
    }

    /**
     * @return bool
     */
    public function hasEntityPath(): bool
    {
        return false;
    }
}
