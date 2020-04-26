<?php

namespace Nip\View\Traits;

use Nip\View\ViewFinder\ViewFinder;
use Nip\View\ViewFinder\ViewFinderInterface;

/**
 * Trait HasPathsTrait
 * @package Nip\View\Traits
 */
trait HasPathsTrait
{
    protected $basePath = null;

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
        $this->getFinder()->prependPath($path);
        return $this;
    }

    /**
     * @return ViewFinderInterface|ViewFinder
     */
    abstract public function getFinder();

    protected function initBasePath()
    {
        $this->setBasePath($this->generateBasePath());
    }

    /**
     * @return string|boolean
     */
    protected function generateBasePath()
    {
        if (defined('VIEWS_PATH')) {
            return VIEWS_PATH;
        }

        return false;
    }
}
