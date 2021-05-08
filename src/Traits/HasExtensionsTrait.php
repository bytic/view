<?php

namespace Nip\View\Traits;

use League\Plates\Extension\ExtensionInterface;

/**
 * Trait HasExtensionsTrait
 * @package Nip\View\Traits
 */
trait HasExtensionsTrait
{
    /**
     * @param ExtensionInterface $extension
     * @deprecated use loadExtension($extension)
     */
    public function register(ExtensionInterface $extension)
    {
        $this->loadExtension($extension);
    }
}
