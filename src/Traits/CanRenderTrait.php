<?php

declare(strict_types=1);

namespace Nip\View\Traits;

use League\Plates\Template\Template;
use function is_string;

/**
 * Class CanRenderTrait.
 */
trait CanRenderTrait
{
    protected $blocks = [];

    /** @noinspection PhpInconsistentReturnPointsInspection
     *
     * @param array $variables
     * @param bool $return
     *
     * @return string|bool
     */
    public function load($view, $variables = [], $return = false)
    {
        $html = $this->getContents($view, $variables);

        if (true === $return) {
            return $html;
        }

        echo $html;

        return null;
    }

    /**
     * @return string
     *
     * @deprecated use render($view, $variables)
     */
    public function getContents($view, array $variables = [])
    {
        return $this->render($view, $variables);
    }

    /**
     * @param string $block
     */
    public function render($name, array $data = [])
    {
        if ($this->isBlock($name)) {
            $name = '/' . $this->blocks[$name];
        }

        return parent::render($name, $data);
    }

    /**
     * Builds path for including
     * If $view starts with / the path will be relative to the root of the views folder.
     * Otherwise to caller file location.
     *
     * @param string $view
     *
     * @return string
     */
    public function buildPath($view)
    {
        return $this->getResolveTemplatePath()->find($view);
    }

    /**
     * @return mixed
     */
    public function getBlock($name)
    {
        return $this->blocks[$name];
    }

    public function setBlock($name, $block)
    {
        $this->blocks[$name] = $block;
    }

    /**
     * @param string $block
     */
    public function isBlock($block = 'default'): bool
    {
        if (!is_string($block)) {
            return false;
        }

        return isset($this->blocks[$block]) && !empty($this->blocks[$block]);
    }

    /**
     * Create a new template.
     *
     * @param string $name
     *
     * @return Template
     */
    public function make($name)
    {
        return new \Nip\View\Template\Template($this, $name);
    }
}
