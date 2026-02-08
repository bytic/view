<?php

declare(strict_types=1);

namespace Nip\View\Tests\Adapters;

use Nip\View\Adapters\PlatesAdapter;
use Nip\View\Tests\AbstractTest;
use League\Plates\Engine;

/**
 * Class PlatesAdapterTest.
 */
class PlatesAdapterTest extends AbstractTest
{
    public function testConstructor()
    {
        $engine = new Engine();
        $adapter = new PlatesAdapter($engine);
        
        self::assertInstanceOf(PlatesAdapter::class, $adapter);
        self::assertSame($engine, $adapter->getEngine());
    }

    public function testRender()
    {
        $engine = new Engine(TEST_FIXTURE_PATH . '/views');
        $adapter = new PlatesAdapter($engine);
        
        $result = $adapter->render('index/index', ['title' => 'Test Title']);
        
        self::assertStringContainsString('Test Title', $result);
    }

    public function testExists()
    {
        $engine = new Engine(TEST_FIXTURE_PATH . '/views');
        $adapter = new PlatesAdapter($engine);
        
        self::assertTrue($adapter->exists('index/index'));
        self::assertFalse($adapter->exists('non/existent'));
    }

    public function testGetSetFileExtension()
    {
        $engine = new Engine();
        $adapter = new PlatesAdapter($engine);
        
        self::assertEquals('php', $adapter->getFileExtension());
        
        $adapter->setFileExtension('phtml');
        self::assertEquals('phtml', $adapter->getFileExtension());
    }

    public function testRegisterFunction()
    {
        $engine = new Engine(TEST_FIXTURE_PATH . '/views');
        $adapter = new PlatesAdapter($engine);
        
        $testValue = 'test_value';
        $adapter->registerFunction('testFunc', function () use ($testValue) {
            return $testValue;
        });
        
        // The function should be registered in the engine
        self::assertTrue($engine->doesFunctionExist('testFunc'));
    }

    public function testAddFolder()
    {
        $engine = new Engine();
        $adapter = new PlatesAdapter($engine);
        
        $adapter->addFolder('test', TEST_FIXTURE_PATH . '/views');
        
        // Folder should be registered
        self::assertTrue($engine->getFolders()->exists('test'));
    }
}
