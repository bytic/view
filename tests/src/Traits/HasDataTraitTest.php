<?php

namespace Nip\View\Tests\Traits;

use Nip\View\Tests\AbstractTest;
use Nip\View\View;

/**
 * Class HasDataTraitTest
 * @package Nip\View\Tests\Traits
 */
class HasDataTraitTest extends AbstractTest
{
    public function test_with_keyValue()
    {
        $view = new View();
        $view->with('test1', 'val1');
        $view->with('test2', 'val2');

        self::assertSame($view->test1, 'val1');
        self::assertSame($view->get('test1'), 'val1');
        self::assertCount(2, $view->getData());
    }

    public function test_with_Array()
    {
        $view = new View();
        $view->with('test1', 'val1');
        $view->with(['test1' => 'val11', 'test2' => 'val2']);

        self::assertSame($view->get('test1'), 'val11');
        self::assertCount(2, $view->getData());
    }
}
