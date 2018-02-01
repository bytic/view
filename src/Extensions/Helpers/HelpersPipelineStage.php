<?php

namespace Nip\View\Extensions\Helpers;

use Nip\View\Methods\Pipeline\MethodCall;
use Nip\View\Methods\Pipeline\Stages\AbstractStage;

/**
 * Class HelpersPipelineStage
 * @package Nip\View\Extensions\Helpers
 */
class HelpersPipelineStage extends AbstractStage
{

    /**
     * @param MethodCall $methodCall
     * @return mixed
     */
    protected function processMethod(MethodCall $methodCall)
    {
        $engine = $methodCall->getEngine();
        if ($engine->hasHelper($methodCall->getName())) {
            return $engine->getHelper($methodCall->getName());
        }
        return null;
    }
}
