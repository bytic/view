<?php

namespace Nip\View\Tests;

use Nip\Container\Container;
use Nip\View\ViewFactory;
use Nip\View\ViewServiceProvider;

/**
 * Class ViewServiceProviderTest
 * @package Nip\View\Tests
 */
class ViewServiceProviderTest extends AbstractTest
{
    public function test_registerFactory()
    {
        $container = new Container();

        $provider = new ViewServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        self::assertInstanceOf(ViewFactory::class, $container->get('view.factory'));
    }
}
