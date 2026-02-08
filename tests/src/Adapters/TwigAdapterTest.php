<?php

declare(strict_types=1);

namespace Nip\View\Tests\Adapters;

use Nip\View\Adapters\TwigAdapter;
use Nip\View\Tests\AbstractTest;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigAdapterTest.
 */
class TwigAdapterTest extends AbstractTest
{
    public function testConstructorWithoutParameters()
    {
        $adapter = new TwigAdapter();
        
        self::assertInstanceOf(TwigAdapter::class, $adapter);
        self::assertInstanceOf(Environment::class, $adapter->getEngine());
        self::assertInstanceOf(FilesystemLoader::class, $adapter->getLoader());
    }

    public function testConstructorWithTwigEnvironment()
    {
        $loader = new FilesystemLoader();
        $twig = new Environment($loader);
        $adapter = new TwigAdapter($twig, $loader);
        
        self::assertSame($twig, $adapter->getEngine());
        self::assertSame($loader, $adapter->getLoader());
    }

    public function testRender()
    {
        $adapter = new TwigAdapter();
        $adapter->addPath(TEST_FIXTURE_PATH . '/twig_templates');
        
        $result = $adapter->render('test', ['title' => 'Test Title']);
        
        self::assertStringContainsString('Test Title', $result);
        self::assertStringContainsString('This is a test template', $result);
    }

    public function testRenderWithExtension()
    {
        $adapter = new TwigAdapter();
        $adapter->addPath(TEST_FIXTURE_PATH . '/twig_templates');
        
        // Should work with or without extension
        $result1 = $adapter->render('test', ['title' => 'Test Title']);
        $result2 = $adapter->render('test.twig', ['title' => 'Test Title']);
        
        self::assertEquals($result1, $result2);
    }

    public function testExists()
    {
        $adapter = new TwigAdapter();
        $adapter->addPath(TEST_FIXTURE_PATH . '/twig_templates');
        
        self::assertTrue($adapter->exists('test'));
        self::assertTrue($adapter->exists('test.twig'));
        self::assertFalse($adapter->exists('non_existent'));
    }

    public function testGetSetFileExtension()
    {
        $adapter = new TwigAdapter();
        
        self::assertEquals('twig', $adapter->getFileExtension());
        
        $adapter->setFileExtension('html.twig');
        self::assertEquals('html.twig', $adapter->getFileExtension());
    }

    public function testRegisterFunction()
    {
        $adapter = new TwigAdapter();
        $adapter->addPath(TEST_FIXTURE_PATH . '/twig_templates');
        
        $testValue = 'custom_value';
        $adapter->registerFunction('testFunc', function () use ($testValue) {
            return $testValue;
        });
        
        // The function should be callable in Twig environment
        $twig = $adapter->getEngine();
        self::assertTrue($twig->getFunction('testFunc') !== null);
    }

    public function testAddPath()
    {
        $adapter = new TwigAdapter();
        $adapter->addPath(TEST_FIXTURE_PATH . '/twig_templates');
        
        // Should be able to render templates from this path
        self::assertTrue($adapter->exists('test'));
    }

    public function testAddPathWithNamespace()
    {
        $adapter = new TwigAdapter();
        $adapter->addPath(TEST_FIXTURE_PATH . '/twig_templates', 'custom');
        
        $loader = $adapter->getLoader();
        $paths = $loader->getPaths('custom');
        
        self::assertCount(1, $paths);
        self::assertStringContainsString('twig_templates', $paths[0]);
    }

    public function testAddFolder()
    {
        $adapter = new TwigAdapter();
        $adapter->addFolder('test', TEST_FIXTURE_PATH . '/twig_templates');
        
        $loader = $adapter->getLoader();
        $paths = $loader->getPaths('test');
        
        self::assertCount(1, $paths);
        self::assertStringContainsString('twig_templates', $paths[0]);
    }
}
