<?php

namespace Nip\View;

use Nip\View\Extensions\Helpers\HasHelpersTrait;
use Nip\View\Traits\HasDataTrait;
use Nip\View\Traits\HasExtensionsTrait;
use Nip\View\Traits\HasMethodsTrait;
use Nip\View\Traits\HasPathsTrait;
use Nip\View\Traits\MethodsOverloadingTrait;
use Nip\View\ViewFinder\HasViewFinder;

/**
 * Class View
 *
 */
class View implements ViewInterface
{
    use HasDataTrait;
    use HasExtensionsTrait;
    use HasHelpersTrait;
    use HasMethodsTrait;
    use HasPathsTrait;
    use HasViewFinder;
    use MethodsOverloadingTrait;

    protected $helpers = [];
    protected $blocks = [];

    public function __construct()
    {
        $this->addMethodsPipelineStage();
        $this->addHelpersExtension();
        $this->initFinder();
    }

    /**
     * @param $name
     * @param $block
     */
    public function setBlock($name, $block)
    {
        $this->blocks[$name] = $block;
    }

    /**
     * @param string $block
     */
    public function render($block = 'default')
    {
        if (!empty($this->blocks[$block])) {
            $this->load("/" . $this->blocks[$block]);
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
     * Builds path for including
     * If $view starts with / the path will be relative to the root of the views folder.
     * Otherwise to caller file location.
     *
     * @param string $view
     * @return string
     */
    public function buildPath($view)
    {
        return $this->getFinder()->find($view);
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
}
