<?php

namespace Bone\View;

interface ViewAwareInterface
{
    /**
     * @param ViewEngineInterface $view
     */
    public function setView(ViewEngineInterface $view): void;

    /**
     * @return ViewEngineInterface
     */
    public function getView(): ViewEngineInterface;
}