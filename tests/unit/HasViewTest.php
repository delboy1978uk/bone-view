<?php declare(strict_types=1);

namespace Bone\Test;

use Bone\View\Traits\HasViewTrait;
use Bone\View\ViewEngine;
use Bone\View\ViewEngineInterface;
use Codeception\Test\Unit;
use Del\SessionManager;

class HasViewTest extends Unit
{
    public function testTrait()
    {
        $class = new class {
          use HasViewTrait;
        };

        $class->setView(new ViewEngine());
        $this->assertInstanceOf(ViewEngineInterface::class, $class->getView());
    }
}
