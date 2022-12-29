<?php

declare(strict_types=1);

namespace Nip\View\Tests;

use Nip\Helpers\View\Messages;
use Nip\Helpers\View\Paginator;
use Nip\Helpers\View\Scripts;
use Nip\View\Helpers\DoctypeHelper;
use Nip\View\View;

/**
 * Class ViewTest.
 */
class ViewTest extends AbstractTest
{
    public function testRenderWithLayout()
    {
        $view = new View();
        $view->setBasePath(TEST_FIXTURE_PATH . '/views');
        $view->setBlock('content', 'index/index');
        $view->set('title', 'TITLE');

        $content = $view->load('/layouts/default', [], true);

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

        static::assertInstanceOf(Messages::class, $view->Messages());
        static::assertInstanceOf(Paginator::class, $view->Paginator());
        static::assertInstanceOf(Scripts::class, $view->Scripts());
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
