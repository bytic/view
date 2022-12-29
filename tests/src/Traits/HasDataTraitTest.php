<?php

declare(strict_types=1);

namespace Nip\View\Tests\Traits;

use Nip\View\Tests\AbstractTest;
use Nip\View\View;

/**
 * Class HasDataTraitTest.
 */
class HasDataTraitTest extends AbstractTest
{
    public function testWithKeyValue()
    {
        $view = new View();
        $view->with('test1', 'val1');
        $view->with('test2', 'val2');

        self::assertSame($view->test1, 'val1');
        self::assertSame($view->get('test1'), 'val1');
        self::assertCount(2, $view->getData());
    }

    public function testWithArray()
    {
        $view = new View();
        $view->with('test1', 'val1');
        $view->with(['test1' => 'val11', 'test2' => 'val2']);

        self::assertSame($view->get('test1'), 'val11');
        self::assertCount(2, $view->getData());
    }
}
