<?php

namespace Nip\View\Methods\Pipeline\Stages;

use Nip\View\Methods\MethodsCollection;
use Nip\View\Methods\Pipeline\MethodCall;

/**
 * Class MethodCollectionStage
 * @package Nip\View\Methods\Pipeline\Stages
 */
class MethodCollectionStage implements StageInterface
{

    /**
     * @param MethodCall $methodCall
     * @return MethodCall
     */
    public function __invoke(MethodCall $methodCall): MethodCall
    {
        $return = $this->callEngineMethods($methodCall);
        if ($return !== null) {
            $methodCall->setReturn($return);
        }
        return $methodCall;
    }

    /**
     * @param MethodCall $methodCall
     * @return mixed
     */
    public function callEngineMethods(MethodCall $methodCall)
    {
        $methodsCollection = $this->getMethodsCollection($methodCall);
        if ($methodsCollection->has($methodCall->getMethod())) {
            return $methodsCollection->run($methodCall->getMethod(), $methodCall->getArgs());
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
