<?php

namespace Nip\View\Traits;

use League\Pipeline\InterruptibleProcessor;
use Nip\View\Methods\Pipeline\MethodCall;
use Nip\View\Methods\Pipeline\MethodsPipelineBuilder as PipelineBuilder;
use Nip\View\Methods\Pipeline\Stages\StageInterface;

/**
 * Trait MethodsOverloadingTrait
 * @package Nip\View\Traits
 */
trait MethodsOverloadingTrait
{
    /**
     * @var null|PipelineBuilder
     */
    protected $callPipelineBuilder = null;

    /**
     * @param $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, array $args)
    {
        $methodReturn = $this->processCallPipeline($method, $args);
        if ($methodReturn->hasReturn()) {
            return $methodReturn->getReturn();
        }
        throw new \BadMethodCallException("No method {$method} found for view engine.");
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return MethodCall
     */
    public function processCallPipeline($method, array $arguments)
    {
        $pipeline = $this->buildCallPipeline();
        return $pipeline->process((new MethodCall($this, $method, $arguments)));
    }

    /**
     * @return \League\Pipeline\PipelineInterface|\League\Pipeline\Pipeline
     */
    protected function buildCallPipeline()
    {
        return $this->getCallPipelineBuilder()->build(
            (
            new InterruptibleProcessor(function (MethodCall $method) {
                return !$method->hasReturn();
            })
            )
        );
    }

    /**
     * @return PipelineBuilder
     */
    public function getCallPipelineBuilder()
    {
        if ($this->callPipelineBuilder === null) {
            $this->initCallPipeline();
        }
        return $this->callPipelineBuilder;
    }

    /**
     * @param StageInterface $stage
     */
    public function addCallPipeline(StageInterface $stage)
    {
        $this->getCallPipelineBuilder()->add($stage);
    }

    /**
     * @param PipelineBuilder $callPipelineBuilder
     */
    public function setCallPipelineBuilder(PipelineBuilder $callPipelineBuilder): void
    {
        $this->callPipelineBuilder = $callPipelineBuilder;
    }


    public function initCallPipeline()
    {
        $this->callPipelineBuilder = (new PipelineBuilder());
    }
}
