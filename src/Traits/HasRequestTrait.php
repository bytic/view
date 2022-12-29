<?php

declare(strict_types=1);

namespace Nip\View\Traits;

/**
 * Trait HasRequestTrait.
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
