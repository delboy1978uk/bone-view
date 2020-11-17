<?php

namespace Bone\View;

interface ViewRegistrationInterface
{
    /**
     * Return an array of the view folders you use
     * e.g. return ['name' => __DIR__ . '/src/View/name'];
     *
     * @return array
     */
    public function addViews(): array;
}