<?php

namespace Nip\View\Methods;

use Nip\Collections\AbstractCollection;

/**
 * Class MethodsCollection
 * @package Nip\View\Methods
 */
class MethodsCollection extends AbstractCollection
{
    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function run($method, $args)
    {
        $methodClosure = $this->get($method);
        return $methodClosure(...$args);
    }
}
