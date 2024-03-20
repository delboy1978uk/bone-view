<?php declare(strict_types=1);

namespace Bone\Test;

use Barnacle\Container;
use Bone\View\ViewEngine;
use Bone\View\ViewEngineInterface;
use Bone\View\ViewPackage;
use Codeception\Test\Unit;

class ViewPackageTest extends Unit
{
    public function testPackage()
    {
        $container = new Container();
        $container['viewFolder'] = 'tests/_data';
        $package = new ViewPackage();
        $package->addToContainer($container);
        $this->assertInstanceOf(ViewEngineInterface::class, $container->get(ViewEngineInterface::class));
    }
}
