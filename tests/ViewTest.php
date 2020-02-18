<?php

namespace Nip\View\Tests;

use Nip\View\View;

/**
 * Class ViewTest
 * @package Nip\View\Tests
 */
class ViewTest extends AbstractTest
{
    public function testHasMethods()
    {
        $view = new View();

        $view->addMethod('methodTest', function ($a, $b, $c) {
            return [$a, $b, $c];
        });

        $parameters = ['a', 'b', 'c'];
        self::assertEquals($parameters, $view->methodTest(...$parameters));
    }

    public function testGetDoctypeHelper()
    {
        $view = new View();

        $helper = $view->Doctype();

        self::assertInstanceOf(View\Helpers\DoctypeHelper::class, $helper);
        self::assertSame(
            '<!DOCTYPE html>',
            $helper->render()
        );
    }


//    public function testGetHelperClass()
//    {
//        $view = new View();
//
//        static::assertEquals('\Nip\Helpers\View\Messages', $view->getHelperClass('Messages'));
//        static::assertEquals('\Nip\Helpers\View\Paginator', $view->getHelperClass('Paginator'));
//        static::assertEquals('\Nip\Helpers\View\Scripts', $view->getHelperClass('Scripts'));
//        static::assertEquals('\Nip\Helpers\View\TinyMCE', $view->getHelperClass('TinyMCE'));
//    }
//
//    public function testDynamicCallHelper()
//    {
//        $view = new View();
//
//        static::assertInstanceOf('Nip\Helpers\View\Messages', $view->Messages());
//        static::assertInstanceOf('Nip\Helpers\View\Paginator', $view->Paginator());
//        static::assertInstanceOf('Nip\Helpers\View\Scripts', $view->Scripts());
//        static::assertInstanceOf('Nip\Helpers\View\TinyMCE', $view->TinyMCE());
//    }
//
//    // tests
//
//    public function testHelperInjectView()
//    {
//        $view = new View();
//
//        static::assertInstanceOf('Nip\View', $view->Messages()->getView());
//        static::assertInstanceOf('Nip\View', $view->Paginator()->getView());
//        static::assertInstanceOf('Nip\View', $view->Scripts()->getView());
//    }
        static::assertInstanceOf(View::class, $view->Messages()->getView());
        static::assertInstanceOf(View::class, $view->Paginator()->getView());
        static::assertInstanceOf(View::class, $view->Scripts()->getView());
        static::assertInstanceOf(View::class, $view->Stylesheets()->getView());
    }
}
