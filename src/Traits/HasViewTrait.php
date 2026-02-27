<?php

namespace Bone\View\Traits;

use Bone\View\ViewEngineInterface;

trait HasViewTrait
{
    protected ViewEngineInterface $view;

    public function setView(ViewEngineInterface $view): void
    {
        $this->view = $view;
    }

    public function getView(): ViewEngineInterface
    {
        return $this->view;
    }
}
