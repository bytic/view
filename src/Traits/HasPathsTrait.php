<?php

declare(strict_types=1);

namespace Nip\View\Traits;

use function defined;
use const DIRECTORY_SEPARATOR;

/**
 * Trait HasPathsTrait.
 */
trait HasPathsTrait
{
    /**
     * @return string
     */
    public function getBasePath()
    {
        if (null === $this->getDirectory()) {
            $this->initBasePath();
        }

        return $this->getDirectory();
    }

    /**
     * @param string $path
     *
     * @return $this
     *
     * @deprecated use Set
     */
    public function setBasePath($path)
    {
        if ($path) {
            $path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            $this->setDirectory($path);
            $this->getResolveTemplatePath()->prependPath($path);
        }

        return $this;
    }

    abstract public function getFinder();

    protected function initBasePath()
    {
        $this->setBasePath($this->generateBasePath());
    }

    /**
     * @return string|bool
     */
    protected function generateBasePath()
    {
        if (defined('VIEWS_PATH')) {
            return VIEWS_PATH;
        }

        return false;
    }
}
