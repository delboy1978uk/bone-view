<?php

namespace Bone\View;

use Barnacle\Container;

interface ViewRegistrationInterface
{
    /**
     * Return an array of the view folders you use
     * e.g. return ['name' => __DIR__ . '/src/View/name'];
     *
     * @return array
     */
    public function addViews(): array;


    /**
     * Return an array of view extensions
     *
     * @param Container $c
     * @return array
     */
    public function addViewExtensions(Container $c): array;
}