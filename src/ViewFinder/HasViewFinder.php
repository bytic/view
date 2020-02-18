<?php

namespace Nip\View\ViewFinder;

use InvalidArgumentException;

/**
 * Trait HasViewFinder
 * @package Nip\View\ViewFinder
 */
trait HasViewFinder
{
    /**
     * The view finder implementation.
     *
     * @var ViewFinderInterface
     */
    protected $finder = null;


    /**
     * Adds a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     *
     * @return void
     */
    public function addPath($path, $namespace = ViewFinderInterface::MAIN_NAMESPACE)
    {
        $this->getFinder()->addPath($path, $namespace);
    }

    /**
     * Prepends a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     * @return void
     */
    public function prependPath($path, $namespace = ViewFinderInterface::MAIN_NAMESPACE)
    {
        $this->getFinder()->prependPath($path, $namespace);
    }

    /**
     * @param $view
     * @return bool
     */
    public function existPath($view)
    {
        try {
            $this->getFinder()->find($view);
        } catch (InvalidArgumentException $exception) {
            return false;
        }
        return true;
    }

    /**
     * Get the view finder instance.
     *
     * @return ViewFinderInterface|ViewFinder
     */
    public function getFinder()
    {
        if ($this->finder === null) {
            $this->initFinder();
        }
        return $this->finder;
    }

    public function initFinder()
    {
        $finder = new ViewFinder();
        $finder->addPath($this->getBasePath());
        $this->setFinder($finder);
    }

    /**
     * Set the view finder instance.
     *
     * @param  ViewFinderInterface $finder
     * @return void
     */
    public function setFinder(ViewFinderInterface $finder)
    {
        $this->finder = $finder;
    }

    abstract public function getBasePath();
}
