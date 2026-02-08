<?php

declare(strict_types=1);

namespace Nip\View\Tests;

use Nip\View\View;
use Nip\View\ViewFactory;

/**
 * Class ViewFactoryTest.
 */
class ViewFactoryTest extends AbstractTest
{
    public function testCreateDefaultView()
    {
        $factory = new ViewFactory();
        $view = $factory->create();
        
        self::assertInstanceOf(View::class, $view);
    }

    public function testCreateWithDirectory()
    {
        $factory = new ViewFactory();
        $view = $factory->create(TEST_FIXTURE_PATH . '/views');
        
        self::assertInstanceOf(View::class, $view);
    }

    public function testSetGetDefaultEngine()
    {
        $factory = new ViewFactory();
        
        self::assertEquals('plates', $factory->getDefaultEngine());
        
        $factory->setDefaultEngine('twig');
        self::assertEquals('twig', $factory->getDefaultEngine());
    }

    public function testSetGetEngineOptions()
    {
        $factory = new ViewFactory();
        $options = ['cache' => false, 'debug' => true];
        
        $factory->setEngineOptions($options);
        self::assertEquals($options, $factory->getEngineOptions());
    }

    public function testCreateWithPlates()
    {
        $factory = new ViewFactory();
        $view = $factory->createWithPlates(TEST_FIXTURE_PATH . '/views');
        
        self::assertInstanceOf(View::class, $view);
        
        // Test that it can render Plates templates
        $view->set('title', 'Test');
        $content = $view->load('index/index', [], true);
        self::assertStringContainsString('Test', $content);
    }

    public function testCreateWithTwig()
    {
        $factory = new ViewFactory();
        $view = $factory->createWithTwig(TEST_FIXTURE_PATH . '/twig_templates');
        
        self::assertInstanceOf(View::class, $view);
        // The adapter is created and stored but not yet integrated into rendering
        // This is the preparation phase
    }

    public function testCreateWithCustomFileExtension()
    {
        $factory = new ViewFactory();
        $view = $factory->create(null, 'phtml', 'plates');
        
        self::assertInstanceOf(View::class, $view);
        self::assertEquals('phtml', $view->getFileExtension());
    }

    public function testFactoryMethodsReturnThis()
    {
        $factory = new ViewFactory();
        
        $result = $factory->setDefaultEngine('twig');
        self::assertSame($factory, $result);
        
        $result = $factory->setEngineOptions(['test' => 'value']);
        self::assertSame($factory, $result);
    }
}
