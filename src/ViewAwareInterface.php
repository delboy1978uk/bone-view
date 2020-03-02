<?php

namespace Bone\View;

interface ViewAwareInterface
{
    /**
     * @param PlatesEngine $view
     */
    public function setView(PlatesEngine $view): void;

    /**
     * @return PlatesEngine
     */
    public function getView(): PlatesEngine;
}