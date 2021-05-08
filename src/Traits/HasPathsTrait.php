<?php

namespace Nip\View\Traits;

use Nip\View\ResolveTemplatePath\ViewFinder;
use Nip\View\ResolveTemplatePath\ViewFinderInterface;

/**
 * Trait HasPathsTrait
 * @package Nip\View\Traits
 */
trait HasPathsTrait
{

    /**
     * @return string
     */
    public function getBasePath()
    {
        if ($this->getDirectory() === null) {
            $this->initBasePath();
        }

        return $this->getDirectory();
    }

    /**
     * @param string $path
     * @return $this
     * @deprecated use Set
     */
    public function setBasePath($path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->setDirectory($path);
        $this->getResolveTemplatePath()->prependPath($path);
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
