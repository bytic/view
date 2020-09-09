<?php

namespace Nip\View\Methods\Pipeline\Stages;

use Nip\View\Methods\MethodsCollection;
use Nip\View\Methods\Pipeline\MethodCall;

/**
 * Class MethodCollectionStage
 * @package Nip\View\Methods\Pipeline\Stages
 */
class MethodCollectionStage extends AbstractStage
{
    /**
     * @param MethodCall $methodCall
     * @return mixed
     */
    public function processMethod(MethodCall $methodCall)
    {
        $methodsCollection = $this->getMethodsCollection($methodCall);
        if ($methodsCollection->has($methodCall->getName())) {
            return $methodsCollection->run($methodCall->getName(), $methodCall->getArgs());
        }
        return null;
    }

    /**
     * @param MethodCall $methodCall
     * @return MethodsCollection
     */
    protected function getMethodsCollection(MethodCall $methodCall)
    {
        return $methodCall->getEngine()->getEngineMethods();
    }
}
