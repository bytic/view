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
     * @param $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, array $args) {
        $methods = $this->container->get('engine_methods');
        if (isset($methods[$method])) {
            return $methods[$method]($this, ...$args);
        }
        throw new \BadMethodCallException("No method {$method} found for engine.");
    }

    /**
     * @param ExtensionInterface $extension
     */
    public function register(ExtensionInterface $extension)
    {
        $extension->register($this);
    }
}
