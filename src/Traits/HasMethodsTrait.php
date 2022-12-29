<?php
declare(strict_types=1);

namespace Nip\View\Traits;

use Closure;
use Nip\View\Methods\MethodsCollection;
use Nip\View\Methods\Pipeline\Stages\MethodCollectionStage;

/**
 * Trait HasMethodsTrait
 * @package Nip\View\Traits
 */
trait HasMethodsTrait
{
    /**
     * Magic method used to call extension functions.
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->getFunction($name)->call(null, $arguments);
    }

    /**
     * @param $name
     * @param callable $callable
     */
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
