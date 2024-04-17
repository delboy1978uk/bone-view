<?php

namespace Bone\View\Extension\Plates;

use Bone\View\Helper\AlertBox as AlertBoxHelper;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use League\Plates\Template\Template;

class AlertBox implements ExtensionInterface
{
    public ?Template $template = null;

    public function register(Engine $engine)
    {
        $engine->registerFunction('alert', [$this, 'alertBox']);
    }
    
    public function alertBox(array $message) : string
    {
        $box = new AlertBoxHelper();

        return $box->alertBox($message);
    }
}
