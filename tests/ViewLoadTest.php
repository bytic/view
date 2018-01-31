<?php

namespace Nip\View\Tests;

use Nip\View;
use Nip\View\Tests\Fixtures\App\View as FixturesView;

/**
 * Class ViewLoadTest
 * @package Nip\View\Tests
 */
class ViewLoadTest extends AbstractTest
{
    public function testLoadWithRelativePath()
    {
        $view = $this->generateView();

        $content = $view->getContents('/modules/header');

        self::assertEquals('TITLE', $content);
    }

    public function testLoadFromInheritedView()
    {
        $view = new FixturesView();
        $view->setBasePath(TEST_FIXTURE_PATH . '/views');

        $content = $view->getContents('/modules/header');

        self::assertEquals('TITLE', $content);
    }

    /**
     * @return View
     */
    protected function generateView()
    {
        $view = new View();
        $view->setBasePath(TEST_FIXTURE_PATH . '/views');
        return $view;
    }
}
