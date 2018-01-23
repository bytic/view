<?php

namespace Nip;

use Nip\View\Traits\HasDataTrait;
use Nip\View\Traits\HasExtensionsTrait;
use Nip\View\Traits\HasHelpersTrait;
use Nip\View\Traits\HasMethodsTrait;
use Nip\View\ViewInterface;

/**
 * Class View
 *
 */
class View implements ViewInterface
{
    use HasDataTrait;
    use HasHelpersTrait;
    use HasExtensionsTrait;
    use HasMethodsTrait;

    protected $request = null;

    protected $helpers = [];
    protected $blocks = [];
    protected $basePath = null;

    /**
     * @param $name
     * @param $block
     */
    public function setBlock($name, $block)
    {
        $this->blocks[$name] = $block;
    }

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
        if ($view[0] == '/') {
            return $this->getBasePath().ltrim($view, "/").'.php';
        } else {
            $backtrace = debug_backtrace();
            $caller = $backtrace[3]['file'];

            return dirname($caller)."/".$view.".php";
        }
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
        $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
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

    /**
     * @param string $block
     */
    public function render($block = 'default')
    {
        if (!empty($this->blocks[$block])) {
            $this->load("/".$this->blocks[$block]);
        } else {
            trigger_error("No $block block", E_USER_ERROR);
        }
    }

    /** @noinspection PhpInconsistentReturnPointsInspection
     *
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return string|boolean
     */
    public function load($view, $variables = [], $return = false)
    {
        $html = $this->getContents($view, $variables);

        if ($return === true) {
            return $html;
        }

        echo $html;

        return null;
    }

    /**
     * @param $view
     * @param array $variables
     * @return string
     */
    public function getContents($view, $variables = [])
    {
        extract($variables);

        $path = $this->buildPath($view);

        unset($view, $variables);
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include($path);
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * @param string $block
     * @return bool
     */
    public function isBlock($block = 'default')
    {
        return empty($this->blocks[$block]) ? false : true;
    }

    /**
     * Assigns variables in bulk in the current scope
     *
     * @param array $array
     * @return $this
     */
    public function assign($array = [])
    {
        foreach ($array as $key => $value) {
            if (is_string($key)) {
                $this->set($key, $value);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}
