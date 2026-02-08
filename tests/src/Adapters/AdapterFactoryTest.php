<?php

declare(strict_types=1);

namespace Nip\View\Tests\Adapters;

use Nip\View\Adapters\AdapterFactory;
use Nip\View\Adapters\PlatesAdapter;
use Nip\View\Adapters\TwigAdapter;
use Nip\View\Tests\AbstractTest;
use League\Plates\Engine as PlatesEngine;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class AdapterFactoryTest.
 */
class AdapterFactoryTest extends AbstractTest
{
    public function testCreatePlatesAdapterByType()
    {
        $adapter = AdapterFactory::create('plates');
        
        self::assertInstanceOf(PlatesAdapter::class, $adapter);
    }

    public function testCreateTwigAdapterByType()
    {
        $adapter = AdapterFactory::create('twig');
        
        self::assertInstanceOf(TwigAdapter::class, $adapter);
    }

    public function testCreatePlatesAdapterWithEngine()
    {
        $engine = new PlatesEngine();
        $adapter = AdapterFactory::create('plates', $engine);
        
        self::assertInstanceOf(PlatesAdapter::class, $adapter);
        self::assertSame($engine, $adapter->getEngine());
    }

    public function testCreateTwigAdapterWithEngine()
    {
        $loader = new FilesystemLoader();
        $engine = new Environment($loader);
        $adapter = AdapterFactory::create('twig', $engine);
        
        self::assertInstanceOf(TwigAdapter::class, $adapter);
        self::assertSame($engine, $adapter->getEngine());
    }

    public function testAutoDetectPlates()
    {
        $engine = new PlatesEngine();
        $adapter = AdapterFactory::create(null, $engine);
        
        self::assertInstanceOf(PlatesAdapter::class, $adapter);
    }

    public function testAutoDetectTwig()
    {
        $loader = new FilesystemLoader();
        $engine = new Environment($loader);
        $adapter = AdapterFactory::create(null, $engine);
        
        self::assertInstanceOf(TwigAdapter::class, $adapter);
    }

    public function testCreatePlatesAdapterWithOptions()
    {
        $options = [
            'directory' => TEST_FIXTURE_PATH . '/views',
            'fileExtension' => 'phtml',
        ];
        
        $adapter = AdapterFactory::createPlatesAdapter(null, $options);
        
        self::assertInstanceOf(PlatesAdapter::class, $adapter);
        self::assertEquals('phtml', $adapter->getFileExtension());
    }

    public function testCreateTwigAdapterWithOptions()
    {
        $options = [
            'directory' => TEST_FIXTURE_PATH . '/twig_templates',
            'twig' => [
                'cache' => false,
                'debug' => true,
            ],
        ];
        
        $adapter = AdapterFactory::createTwigAdapter(null, $options);
        
        self::assertInstanceOf(TwigAdapter::class, $adapter);
        
        // Verify directory was added
        self::assertTrue($adapter->exists('test'));
    }

    public function testDefaultToPlatesWhenNoTypeSpecified()
    {
        $adapter = AdapterFactory::create();
        
        self::assertInstanceOf(PlatesAdapter::class, $adapter);
    }
}
