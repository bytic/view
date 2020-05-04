<?php

namespace Nip\View\Traits;

/**
 * Class CanRenderTrait
 * @package Nip\View\Traits
 */
trait CanRenderTrait
{
    /**
     * @param bool $condition
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadIf($condition, $view, $variables = [], $return = false)
    {
        if ($condition == false) {
            return;
        }
        return $this->load($view, $variables, $return);
    }

    /**
     * @param $view
     * @param array $variables
     * @param bool $return
     * @return bool|string|void|null
     */
    public function loadIfExists($view, $variables = [], $return = false)
    {
        if ($this->existPath($view)) {
            return;
        }
        return $this->load($view, $variables, $return);
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
}
