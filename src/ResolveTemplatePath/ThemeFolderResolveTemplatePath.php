<?php

declare(strict_types=1);

namespace Nip\View\ResolveTemplatePath;

use InvalidArgumentException;
use League\Plates\Engine;
use League\Plates\Exception\TemplateNotFound;
use League\Plates\Template\Name;
use League\Plates\Template\ResolveTemplatePath;
use Nip\View\Utilities\Backtrace;
use function count;
use function dirname;
use function is_array;
use function is_string;

/**
 * Class ViewFinder.
 */
class ThemeFolderResolveTemplatePath implements ResolveTemplatePath
{
    /**
     * Hint path delimiter value.
     *
     * @var string
     */
    public const HINT_PATH_DELIMITER = '::';

    /**
     * Identifier of the main namespace.
     *
     * @var string
     */
    public const MAIN_NAMESPACE = '__main__';

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
     * @var Engine
     */
    protected $engine;

    /**
     * ThemeFolderResolveTemplatePath constructor.
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public function __invoke(Name $name): string
    {
        return $this->find($name->getName());
    }

    /**
     * Get the fully qualified location of the view.
     *
     * @param string $name
     *
     * @return string
     */
    public function find($name)
    {
        if (is_file($name)) {
            return $name;
        }
        [$namespace, $view] = $this->parseName($name);

        if (self::MAIN_NAMESPACE == $namespace && $this->isRelativeView($view)) {
            return $this->findRelativePathView($view);
        }

        return $this->findNamespacedView($view, $namespace);
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
        if ($this->engine->getFolders()->exists($namespace)) {
            $this->engine->getFolders()->get($namespace)->setPath($path);

            return;
        }
        $this->engine->addFolder($namespace, $path);
    }

    /**
     * Prepends a path where templates are stored.
     *
     * @param string $path A path where to look for templates
     * @param string $namespace A path namespace
     *
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
     * Get the path to a template with a relative path.
     *
     * @param string $name
     *
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
     * @param string $name
     *
     * @return string
     */
    protected function findNamespacedView($name, $namespace)
    {
        return $this->findInPaths($name, $this->paths[$namespace]);
    }

    /**
     * @param string $namespace
     *
     * @return array
     */
    public function parseName($name, $namespace = self::MAIN_NAMESPACE)
    {
        $name = trim($name);
        if ($this->hasNamespaceInformation($name)) {
            return $this->parseNamespacedName($name);
        }

        return [$namespace, $name];
    }

    /**
     * Get the segments of a template with a named path.
     *
     * @param string $name
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    protected function parseNamespacedName($name)
    {
        $segments = explode(static::HINT_PATH_DELIMITER, $name);
        if (2 != count($segments)) {
            throw new InvalidArgumentException("View [$name] has an invalid name.");
        }
        if (!isset($this->paths[$segments[0]]) || count($this->paths[$segments[0]]) < 1) {
            throw new InvalidArgumentException("No path defined for namespace [{$segments[0]}].");
        }

        return $segments;
    }

    public function isRelativeView($name): bool
    {
        if (!is_string($name)) {
            return false;
        }

        return '/' !== substr($name, 0, 1);
    }

    /**
     * Find the given view in the list of paths.
     *
     * @param string $name
     * @param array $paths
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function findInPaths($name, $paths)
    {
        $paths = (array)$paths;
        foreach ($paths as $path) {
            $file = $this->getViewFilename($name);
            $viewPath = $path . '/' . $file;
            if (file_exists($viewPath)) {
                return $viewPath;
            }
        }
        throw new TemplateNotFound($name, $paths,
            'View [' . $name . '] not found in paths [' . implode(', ', $paths) . '].');
    }

    /**
     * Get an view file name with extension.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getViewFilename($name)
    {
        return $name . '.php';
    }

    /**
     * Returns whether or not the view name has any hint information.
     *
     * @param string $name
     *
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
