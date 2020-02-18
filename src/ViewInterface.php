<?php

namespace Nip\View;

use Nip\View\Methods\Pipeline\MethodsPipelineBuilder as PipelineBuilder;

/**
 * Interface ViewInterface
 * @package Nip\View
 */
interface ViewInterface
{

    /**
     * @return PipelineBuilder
     */
    public function getCallPipelineBuilder();
}
