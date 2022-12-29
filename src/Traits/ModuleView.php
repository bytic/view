<?php

declare(strict_types=1);

namespace Nip\View\Traits;

use Nip\Mvc\Modules;
use ReflectionClass;
use function dirname;
use const DIRECTORY_SEPARATOR;

/**
 * Class ModuleView.
 */
trait ModuleView
{
    /**
     * @return string
     */
    protected function generateBasePath()
    {
        $folderPath = $this->generateFolderBasePath();
        if (is_dir($folderPath)) {
            return $folderPath;
        }

        return $this->generateModuleBasePath();
    }

    /**
     * @return string
     */
    public function generateModuleBasePath()
    {
        /** @var Modules $modules */
        $modules = app('mvc.modules');

        return $modules->getViewPath($this->getModuleName());
    }

    /**
     * @return string
     */
    public function generateFolderBasePath()
    {
        $reflector = new ReflectionClass(static::class);
        $dirName = dirname($reflector->getFileName());

        return dirname($dirName, 2) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return 'default';
    }
}
