<?php

namespace Nip\View\ResolveTemplatePath;

use League\Plates\Exception\TemplateNotFound;
use League\Plates\Template\Name;

/**
 * Trait HasViewFinder
 * @package Nip\View\ViewFinder
 */
trait HasViewFinder
{

    /**
     * Adds a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     *
     * @return void
     */
    public function addPath($path, $namespace = ThemeFolderResolveTemplatePath::MAIN_NAMESPACE)
    {
        $this->getResolveTemplatePath()->addPath($path, $namespace);
    }

    /**
     * Prepends a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     * @return void
     */
    public function prependPath($path, $namespace = ThemeFolderResolveTemplatePath::MAIN_NAMESPACE)
    {
        $this->getResolveTemplatePath()->prependPath($path, $namespace);
    }

    /**
     * @param $view
     * @return bool
     */
    public function existPath($view): bool
    {
        try {
            $name = new Name($this, $view);
            ($this->getResolveTemplatePath())($name);
            return true;
        } catch (TemplateNotFound $exception) {
            return false;
        }
    }

    /**
     * @deprecated use getResolveTemplatePath
     */
    public function getFinder(): \League\Plates\Template\ResolveTemplatePath
    {
        return $this->getResolveTemplatePath();
    }
}
