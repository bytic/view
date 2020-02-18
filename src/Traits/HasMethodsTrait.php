<?php

namespace Nip\View\Traits;

use Closure;
use Nip\View\Methods\MethodsCollection;
use Nip\View\Methods\Pipeline\Stages\MethodCollectionStage;

/**
 * Trait HasMethodsTrait
 * @package Nip\View\Traits
 */
trait HasMethodsTrait
{
    protected $engineMethods = null;

    public function addMethodsPipelineStage()
    {
        $this->addCallPipeline(new MethodCollectionStage());
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
     * @param Closure $callable
     */
    public function addMethod($name, Closure $callable)
    {
        $this->getEngineMethods()->set($name, $callable);
    }

    /**
     * @param Closure[] $methods
     */
    public function addMethods(array $methods)
    {
        foreach ($methods as $name => $closure) {
            $this->addMethod($name, $closure);
        }
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
