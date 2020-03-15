<?php

declare(strict_types=1);

namespace Bone\View;

use Barnacle\Container;
use Barnacle\RegistrationInterface;
use Bone\View\Extension\Plates\AlertBox;
use Bone\View\ViewEngine;

class ViewPackage implements RegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        // set up the view engine dependencies
        $viewEngine = new ViewEngine($c->get('viewFolder'));
        $viewEngine->loadExtension(new AlertBox());

        $c[ViewEngine::class] = $viewEngine;
    }
}
