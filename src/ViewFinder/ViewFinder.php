<?php

namespace Nip\View\ViewFinder;

use InvalidArgumentException;
use Nip\View\Utilities\Backtrace;

/**
 * Class ViewFinder
 * @package Nip\View\ViewFinder
 */
class ViewFinder implements ViewFinderInterface
{
    /**
     * The array of active view paths.
     *
     * @var array
     */
    protected $paths = [];

    /**
     * @var string
     */
    protected $rootPath;


    /**
     * Get the fully qualified location of the view.
     *
     * @param  string $name
     * @return string
     */
    public function find($name)
    {
        list($namespace, $view) = $this->parseName($name);

        if ($namespace == self::MAIN_NAMESPACE && $this->isRelativeView($view)) {
            return $this->findRelativePathView($view);
        }

        return $this->findNamespacedView($view, $namespace);
    }

    /**
     * Get the path to a template with a relative path.
     *
     * @param  string $name
     * @return string
     */
    protected function findRelativePathView($name)
    {
        $caller = Backtrace::getViewOrigin();
        return $this->findInPaths($name, [dirname($caller)]);
    }

    /**
     * Get the path to a template with a named path.
     *
     * @param  string $name
     * @param $namespace
     * @return string
     */
    protected function findNamespacedView($name, $namespace)
    {
        return $this->findInPaths($name, $this->paths[$namespace]);
    }

    /**
     * @param $name
     * @param string $namespace
     * @return array
     */
    public function parseName($name, $namespace = self::MAIN_NAMESPACE)
    {
        if ($this->hasNamespaceInformation($name = trim($name))) {
            return $this->parseNamespacedName($name);
        }
        return [$namespace, $name];
    }

    /**
     * Get the segments of a template with a named path.
     *
     * @param  string $name
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function parseNamespacedName($name)
    {
        $segments = explode(static::HINT_PATH_DELIMITER, $name);
        if (count($segments) != 2) {
            throw new InvalidArgumentException("View [$name] has an invalid name.");
        }
        if (!isset($this->paths[$segments[0]]) || count($this->paths[$segments[0]]) < 1) {
            throw new InvalidArgumentException("No path defined for namespace [{$segments[0]}].");
        }
        return $segments;
    }

    /**
     * @param $name
     * @return bool
     */
    public function isRelativeView($name)
    {
        return $name[0] !== '/';
    }

    /**
     * Find the given view in the list of paths.
     *
     * @param  string $name
     * @param  array $paths
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function findInPaths($name, $paths)
    {
        foreach ((array)$paths as $path) {
            $file = $this->getViewFilename($name);
            if (file_exists($viewPath = $path . '/' . $file)) {
                return $viewPath;
            }
        }
        throw new InvalidArgumentException(
            'View [' . $name . '] not found in paths [' . implode(', ', $paths) . '].'
        );
    }

    /**
     * Get an view file name with extension.
     *
     * @param  string $name
     * @return string
     */
    protected function getViewFilename($name)
    {
        return $name . '.php';
    }

    /**
     * Adds a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     *
     * @return void
     */
    public function addPath($path, $namespace = self::MAIN_NAMESPACE)
    {
        $this->paths[$namespace][] = rtrim($path, '/\\');
    }

    /**
     * Prepends a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     * @return void
     */
    public function prependPath($path, $namespace = self::MAIN_NAMESPACE)
    {
        $path = rtrim($path, '/\\');

        if (!isset($this->paths[$namespace])) {
            $this->paths[$namespace][] = $path;
        } else {
            array_unshift($this->paths[$namespace], $path);
        }
    }

    /**
     * Sets the paths where templates are stored.
     *
     * @param string|array $paths A path or an array of paths where to look for templates
     * @param string $namespace A path namespace
     */
    public function setPaths($paths, $namespace = self::MAIN_NAMESPACE)
    {
        if (!is_array($paths)) {
            $paths = [$paths];
        }
        $this->paths[$namespace] = [];
        foreach ($paths as $path) {
            $this->addPath($path, $namespace);
        }
    }

    /**
     * Returns whether or not the view name has any hint information.
     *
     * @param  string $name
     * @return bool
     */
    public function hasNamespaceInformation($name)
    {
        return strpos($name, static::HINT_PATH_DELIMITER) > 0;
    }

    /**
     * Get the active view paths.
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }
}
