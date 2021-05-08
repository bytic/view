<?php

namespace Nip\View\Tests;

use Nip\View\Helpers\DoctypeHelper;
use Nip\View\View;

/**
 * Class ViewTest
 * @package Nip\View\Tests
 */
class ViewTest extends AbstractTest
{
    public function test_render_with_layout()
    {
        $view = new View();
        $view->setBasePath(TEST_FIXTURE_PATH . '/views');
        $view->setBlock('content', 'index/index');
        $view->set('title', 'TITLE');

        $content = $view->load('/layouts/default',[], true);

        self::assertSame(
            file_get_contents(TEST_FIXTURE_PATH . '/html/complete_output.html'),
            $content
        );
    }


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

        self::assertInstanceOf(DoctypeHelper::class, $helper);
        self::assertStringStartsWith(
            '<!DOCTYPE html',
            $helper->render()
        );
    }

    public function testDynamicCallHelper()
    {
        $view = new View();

        static::assertInstanceOf(\Nip\Helpers\View\Messages::class, $view->Messages());
        static::assertInstanceOf(\Nip\Helpers\View\Paginator::class, $view->Paginator());
        static::assertInstanceOf(\Nip\Helpers\View\Scripts::class, $view->Scripts());
        static::assertInstanceOf(\Nip\Helpers\View\TinyMCE::class, $view->TinyMCE());
    }

//
//    public function testHelperInjectView()
//    {
//        $view = new View();
//
//        static::assertInstanceOf('Nip\View', $view->Messages()->getView());
//        static::assertInstanceOf('Nip\View', $view->Paginator()->getView());
//        static::assertInstanceOf('Nip\View', $view->Scripts()->getView());
//    }
}
