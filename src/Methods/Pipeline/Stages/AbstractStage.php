<?php

namespace Nip\View\Methods\Pipeline\Stages;

use Nip\View\Methods\Pipeline\MethodCall;

/**
 * Class AbstractStage
 * @package Nip\View\Methods\Pipeline\Stages
 */
abstract class AbstractStage implements StageInterface
{
    /**
     * @param MethodCall $methodCall
     * @return MethodCall
     */
    public function __invoke(MethodCall $methodCall): MethodCall
    {
        $return = $this->processMethod($methodCall);
        if ($return !== null) {
            $methodCall->setReturn($return);
        }
        return $methodCall;
    }

    /**
     * @param MethodCall $methodCall
     * @return mixed
     */
    abstract protected function processMethod(MethodCall $methodCall);
}
