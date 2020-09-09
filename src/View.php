<?php

namespace Nip\View;

use ArrayAccess;
use Nip\View\Extensions\Helpers\HasHelpersTrait;
use Nip\View\ViewFinder\HasViewFinder;

/**
 * Class View
 *
 */
class View implements ViewInterface, ArrayAccess
{
    use Traits\CanRenderTrait;
    use Traits\HasDataTrait;
    use Traits\HasExtensionsTrait;
    use HasHelpersTrait;
    use Traits\HasMethodsTrait;
    use Traits\HasPathsTrait;
    use Traits\HasRequestTrait;
    use Traits\MethodsOverloadingTrait;

    use HasViewFinder;

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
