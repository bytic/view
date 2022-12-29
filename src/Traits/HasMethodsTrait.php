<?php

declare(strict_types=1);

namespace Nip\View\Traits;

use Closure;

/**
 * Trait HasMethodsTrait.
 */
trait HasMethodsTrait
{
    /**
     * Magic method used to call extension functions.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->getFunction($name)->call(null, $arguments);
    }

    public function addMethod($name, callable $callable): void
    {
        $this->registerFunction($name, $callable);
    }

    /**
     * @param Closure[] $methods
     */
    public function addMethods(array $methods)
    {
        foreach ($methods as $name => $closure) {
            $this->addMethod($name, $closure);
        }
    }
}
