<?php

namespace Nip\View\Extensions;

use Nip\View\Traits\HasExtensionsTrait;
use Nip\View\ViewInterface;

/**
 * Interface ExtensionInterface
 * @package Nip\View\Extensions
 */
interface ExtensionInterface
{
    /**
     * @param ViewInterface|HasExtensionsTrait $view
     * @return mixed
     */
    public function register(ViewInterface $view);
}
