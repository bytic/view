<?php
declare(strict_types=1);

namespace Nip\View\Tests;

use League\Plates\Exception\TemplateNotFound;
use Nip\View;
use Nip\View\Tests\Fixtures\App\View as FixturesView;

/**
 * Class ViewLoadTest
 * @package Nip\View\Tests
 */
class ViewLoadTest extends AbstractTest
{
    public function testLoadWithInnerLoadIfExists()
    {
        $view = $this->generateView();

        $content = $view->render('/index/boilerplate', ['content' => 'test']);

        self::assertEquals(
            'TITLETITLE' . "\n",
            $content,
        );
    }

    public function testLoadWithRelativePath()
    {
        $view = $this->generateView();

        $content = $view->getContents('/modules/header');

        self::assertEquals('TITLE', $content);
    }

    public function testLoadFromMultiplePath()
    {
        $view = $this->generateView();

        $content = $view->getContents('/modules/header');
        self::assertEquals('TITLE', $content);

        $view->prependPath(TEST_FIXTURE_PATH . '/views_template');

        $content = $view->getContents('/modules/header');
        self::assertEquals('TITLE TEMPLATE', $content);

        $content = $view->getContents('/modules/footer');
        self::assertEquals('FOOTER', $content);
    }

    public function testLoadNamespacePath()
    {
        $view = $this->generateView();
        $view->addPath(TEST_FIXTURE_PATH . '/views_template', 'template');

        $content = $view->getContents('template::/modules/header');
        self::assertEquals('TITLE TEMPLATE', $content);

        $content = $view->getContents('template::modules/header');
        self::assertEquals('TITLE TEMPLATE', $content);

        self::expectException(TemplateNotFound::class);
        $view->getContents('template::/modules/footer');
    }

    public function test_load_layout_from_view()
    {
        $view = $this->generateView();
        $content = $view->render('/index/index_with_layout');
        self::assertStringContainsString('TITLE', $content);
        self::assertStringContainsString('<aside>', $content);
        self::assertStringContainsString('FOOTER', $content);
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
        $view->setBasePath(TEST_FIXTURE_PATH . DIRECTORY_SEPARATOR . 'views');
        return $view;
    }
}
