<?php

namespace Nip\View\Traits;

use Nip\View\Extensions\ExtensionInterface;

/**
 * Trait HasExtensionsTrait
 * @package Nip\View\Traits
 */
trait HasExtensionsTrait
{
    /**
     * @param ExtensionInterface $extension
     */
    public function register(ExtensionInterface $extension)
    {
        $extension->register($this);
    }
}
