<?php

namespace Bone\View\Traits;

use Bone\View\ViewEngineInterface;

trait HasViewTrait
{
    /** @var ViewEngineInterface $view */
    protected $view;

    /**
     * @param ViewEngineInterface $view
     */
    public function setView(ViewEngineInterface $view): void
    {
        $this->view = $view;
    }

    /**
     * @return ViewEngineInterface
     */
    public function getView(): ViewEngineInterface
    {
        return $this->view;
    }
}