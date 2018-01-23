<?php

namespace Nip\View\Traits;

/**
 * Trait HasRequestTrait
 * @package Nip\View\Traits
 */
trait HasRequestTrait
{
    protected $request = null;

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}
