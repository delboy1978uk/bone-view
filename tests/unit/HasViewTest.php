<?php declare(strict_types=1);

namespace BoneTest;

use Bone\View\Traits\HasViewTrait;
use Bone\View\ViewEngine;
use Bone\View\ViewEngineInterface;
use Codeception\TestCase\Test;
use Del\SessionManager;

class HasViewTest extends Test
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
