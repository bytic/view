<?php

namespace Nip\View\Traits;

use Nip\View\Methods\MethodsCollection;

/**
 * Trait HasMethodsTrait
 * @package Nip\View\Traits
 */
trait HasMethodsTrait
{

    protected $engineMethods = null;

    public function __call($method, array $args)
    {
        $methods = $this->container->get('engine_methods');
        if (isset($methods[$method])) {
            return $methods[$method]($this, ...$args);
        }
        throw new \BadMethodCallException("No method {$method} found for engine.");
    }

    /**
     * @return MethodsCollection
     */
    public function getEngineMethods(): MethodsCollection
    {
        if ($this->engineMethods === null) {
            $this->initEngineMethods();
        }
        return $this->engineMethods;
    }

    /**
     * @param MethodsCollection $engineMethods
     */
    public function setEngineMethods(MethodsCollection $engineMethods): void
    {
        $this->engineMethods = $engineMethods;
    }

    /**
     * @param $name
     * @param $callable
     */
    public function addMethod($name, $callable)
    {
        $this->getEngineMethods()->add($name, $callable);
    }

    public function addMethods(array $methods)
    {
        $this->getEngineMethods()->merge('engine_methods', $methods);
    }

    protected function initEngineMethods()
    {
        $methods = $this->newEngineMethods();
        $this->setEngineMethods($methods);
    }

    /**
     * @return MethodsCollection
     */
    protected function newEngineMethods()
    {
        return new MethodsCollection();
    }
}