<?php

declare(strict_types=1);

namespace Nip\View\Tests\Traits;

use Nip\Http\Request;
use Nip\View\Tests\AbstractTest;
use Nip\View\Tests\Fixtures\App\View;

/**
 * Class HasRequestTraitTest.
 */
class HasRequestTraitTest extends AbstractTest
{
    public function testGetRequestIsNull()
    {
        $view = new View();
        self::assertNull($view->getRequest());
    }

    public function testSetRequest()
    {
        $view = new View();
        $request = new Request();
        $view->setRequest($request);
        self::assertSame($request, $view->getRequest());
    }
}
