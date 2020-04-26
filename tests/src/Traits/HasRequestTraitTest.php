<?php

namespace Nip\View\Tests\Traits;

use Nip\Request;
use Nip\View\Tests\AbstractTest;
use Nip\View\Tests\Fixtures\App\View;

/**
 * Class HasRequestTraitTest
 * @package Nip\View\Tests\Traits
 */
class HasRequestTraitTest extends AbstractTest
{
    public function test_getRequest_is_null()
    {
        $view = new View();
        self::assertNull($view->getRequest());
    }

    public function test_setRequest()
    {
        $view = new View();
        $request = new Request();
        $view->setRequest($request);
        self::assertSame($request, $view->getRequest());
    }
}
