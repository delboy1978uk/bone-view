<?php

namespace Bone\View\Extension\Plates;

use Bone\View\Helper\AdminLinks as AdminLinksHelper;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use League\Plates\Template\Template;

class AdminLinks implements ExtensionInterface
{
    public ?Template $template = null;

    public function __construct(
        private array $packages
    ) {}


    public function register(Engine $engine)
    {
        $engine->registerFunction('adminLinks', [$this, 'adminLinks']);
    }

    public function adminLinks() : string
    {
        $helper = new AdminLinksHelper($this->packages);

        return $helper->links();
    }
}
