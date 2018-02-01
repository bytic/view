<?php

namespace Nip\View\ViewFinder;

/**
 * Interface ViewFinderInterface
 * @package Nip\View\ViewFinder
 */
interface ViewFinderInterface
{
    /**
     * Hint path delimiter value.
     *
     * @var string
     */
    const HINT_PATH_DELIMITER = '::';

    /**
     * Identifier of the main namespace.
     *
     * @var string
     */
    const MAIN_NAMESPACE = '__main__';

    /**
     * Get the fully qualified location of the view.
     *
     * @param  string $view
     * @return string
     */
    public function find($view);

    /**
     * Adds a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     *
     * @return void
     */
    public function addPath($path, $namespace = self::MAIN_NAMESPACE);

    /**
     * Prepends a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     * @return void
     */
    public function prependPath($path, $namespace = self::MAIN_NAMESPACE);

    /**
     * Sets the paths where templates are stored.
     *
     * @param string|array $paths A path or an array of paths where to look for templates
     * @param string $namespace A path namespace
     */
    public function setPaths($paths, $namespace = self::MAIN_NAMESPACE);
}
