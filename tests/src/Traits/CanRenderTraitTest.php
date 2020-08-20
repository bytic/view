<?php

namespace Nip\View\Tests\Traits;

use Mockery\Mock;
use Nip\View\Tests\AbstractTest;
use Nip\View\View;

/**
 * Class CanRenderTraitTest
 * @package Nip\View\Tests\Traits
 */
class CanRenderTraitTest extends AbstractTest
{
    public function test_loadIfExists()
    {
        /** @var Mock|View $view */
        $view = \Mockery::mock(View::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $view->shouldReceive('load')->andReturn('html');
        $view->shouldReceive('existPath')->with('view_exist')->andReturn(true);
        $view->shouldReceive('existPath')->with('view_dnx')->andReturn(false);

        static::assertSame('html', $view->loadIfExists('view_exist'));
        static::assertNull($view->loadIfExists('view_dnx'));
    }

    public function test_loadIf()
    {
        /** @var Mock|View $view */
        $view = \Mockery::mock(View::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $view->shouldReceive('load')->andReturn('html');

        static::assertSame('html', $view->loadIf(true, 'view_exist'));
        static::assertNull($view->loadIf(false, 'view_dnx'));

        static::assertSame('html', $view->loadIf(function () {
            return true;
        }, 'view_exist'));
        static::assertNull($view->loadIf(function () {
            return false;
        }, 'view_dnx'));
    }
}
