<?php

namespace Nip\View\Tests\Fixtures\App;

/**
 * Class View
 * @package Nip\View\Tests\Fixtures
 */
class View extends \Nip\View
{
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
        return parent::buildPath($view);
    }
}
