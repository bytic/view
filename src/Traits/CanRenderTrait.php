<?php
declare(strict_types=1);

namespace Nip\View\Traits;

use League\Plates\Template\Template;

/**
 * Class CanRenderTrait
 * @package Nip\View\Traits
 */
trait CanRenderTrait
{
    protected $blocks = [];

    /**
     * @param bool|Callable $condition
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadIf($condition, $view, $variables = [], $return = false)
    {
        $condition = is_callable($condition) ? $condition() : $condition;
        if ($condition == false) {
            return;
        }
        return $this->load($view, $variables, $return);
    }

    /**
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadIfExists($view, $variables = [], $return = false)
    {
        return $this->loadIf($this->existPath($view), $view, $variables, $return);
    }

    /**
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadWithFallback($view, $fallback, $variables = [], $return = false)
    {
        $view = $this->existPath($view) ? $view : $fallback;
        return $this->load($view, $variables, $return);
    }

    /** @noinspection PhpInconsistentReturnPointsInspection
     *
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return string|boolean
     */
    public function load($view, $variables = [], $return = false)
    {
        $html = $this->getContents($view, $variables);

        if ($return === true) {
            return $html;
        }

        echo $html;

        return null;
    }

    /**
     * @param $view
     * @param array $variables
     * @return string
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
            $name = "/" . $this->blocks[$name];
        }
        return parent::render($name, $data);
    }

    /**
     * Builds path for including
     * If $view starts with / the path will be relative to the root of the views folder.
     * Otherwise to caller file location.
     *
     * @param string $view
     * @return string
     */
    public function buildPath($view)
    {
        return $this->getResolveTemplatePath()->find($view);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getBlock($name)
    {
        return $this->blocks[$name];
    }

    /**
     * @param $name
     * @param $block
     */
    public function setBlock($name, $block)
    {
        $this->blocks[$name] = $block;
    }

    /**
     * @param string $block
     * @return bool
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
     * @param string $name
     * @return Template
     */
    public function make($name)
    {
        return new \Nip\View\Template\Template($this, $name);
    }
}
