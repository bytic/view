<?php

declare(strict_types=1);

namespace Nip\View\Traits;

use League\Plates\Extension\ExtensionInterface;

/**
 * Trait HasExtensionsTrait.
 */
trait HasExtensionsTrait
{
    /**
     * @deprecated use loadExtension($extension)
     */
    public function register(ExtensionInterface $extension)
    {
        $this->loadExtension($extension);
    }
}
