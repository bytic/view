<?php

namespace Nip\View\Traits;

use Nip\View\Utilities\Backtrace;

/**
 * Trait HasPathsTrait
 * @package Nip\View\Traits
 */
trait HasPathsTrait
{
    protected $basePath = null;

    /**
     * @param $view
     * @return bool
     */
    public function existPath($view)
    {
        return is_file($this->buildPath($view));
    }

    /**
     * Builds path for including
     * If $view starts with / the path will be relative to the root of the views folder.
     * Otherwise to caller file location.
     *
     * @param string $view
     * @return string
     */
    protected function buildPath($view)
    {
        if ($this->isAbsolutePath($view)) {
            return $this->getBasePath() . ltrim($view, "/") . '.php';
        } else {
            $caller = Backtrace::getViewOrigin();
            return dirname($caller) . "/" . $view . ".php";
        }
    }

    /**
     * @param $path
     * @return bool
     */
    public function isAbsolutePath($path)
    {
        return $path[0] == '/';
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        if ($this->basePath === null) {
            $this->initBasePath();
        }

        return $this->basePath;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setBasePath($path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->basePath = $path;

        return $this;
    }

    protected function initBasePath()
    {
        $this->setBasePath($this->generateBasePath());
    }

    /**
     * @return string
     */
    protected function generateBasePath()
    {
        if (defined('VIEWS_PATH')) {
            return VIEWS_PATH;
        }

        return false;
    }
}
