<?php

namespace Nip\View\Methods\Pipeline\Stages;

use Nip\View\Methods\Pipeline\MethodCall;

/**
 * Interface StageInterface
 * @package Nip\View\Methods\Pipeline
 */
interface StageInterface
{
    /**
     * @param MethodCall $methodCall
     * @return MethodCall
     */
    public function __invoke(MethodCall $methodCall): MethodCall;
}
