<?php

declare(strict_types=1);

namespace Bone\View\Helper;

use Bone\Contracts\Container\AdminPanelProviderInterface;
use Bone\View\Util\AdminLink;

class AdminLinks
{
    private string $ulClass = 'nav nav-pills nav-sidebar flex-column';
    private string $liClass = 'nav-item';
    private string $aClass = 'nav-link';
    private string $iClass = 'nav-icon fa fa-circle';

    public function __construct(
        private array $packages
    ) {}

    public function links()
    {
        $html = '<ul class="' . $this->ulClass .'" data-widget="treeview" role="menu" data-accordion="false">';

        foreach ($this->packages as $class) {
            $package = new $class();

            if ($package instanceof AdminPanelProviderInterface) {
                $links = $package->getAdminLinks();

                /** @var  AdminLink $link*/
                foreach ($links as $link) {
                    $name = $link->getName();
                    $url = $link->getUrl();
                    $iClass = $link->getIconClass() ?? $this->iClass;
                    $aClass = $link->getAClass() ?? $this->aClass;
                    $liClass = $link->getLiClass() ?? $this->liClass;
                    $html .= '<li class="' . $liClass . '">';
                    $html .= '<a class="' . $aClass . '" href="' . $url . '">';
                    $html .= '<i class="' . $iClass . '"></i>';
                    $html .= '<p>' . $name . '</p>';
                    $html .= '</a>';
                    $html .= '</li>';
                }
            }
        }

        $html .= '</ul>';

        return $html;
    }
}
