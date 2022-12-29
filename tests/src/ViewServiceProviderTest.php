<?php

declare(strict_types=1);

namespace Nip\View\Tests;

use Nip\Container\Container;
use Nip\View\ViewFactory;
use Nip\View\ViewServiceProvider;

/**
 * Class ViewServiceProviderTest.
 */
class ViewServiceProviderTest extends AbstractTest
{
    public function testRegisterFactory()
    {
        $container = new Container();

        $provider = new ViewServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        self::assertInstanceOf(ViewFactory::class, $container->get('view.factory'));
    }
}
