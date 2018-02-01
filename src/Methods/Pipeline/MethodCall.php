<?php

namespace Nip\View\Methods\Pipeline;

use Nip\View;
use Nip\View\Traits\MethodsOverloadingTrait;
use Nip\View\ViewInterface;

/**
 * Class MethodCall
 * @package Nip\View\Methods\Pipeline
 */
class MethodCall
{
    /**
     * @var View|MethodsOverloadingTrait|ViewInterface
     */
    private $engine;

    private $method;

    private $args;

    private $return = null;

    /**
     * MethodCall constructor.
     * @param ViewInterface|MethodsOverloadingTrait|View $engine
     * @param string $method
     * @param array $args
     */
    public function __construct($engine, $method, $args)
    {
        $this->engine = $engine;
        $this->method = $method;
        $this->args = $args;
    }

    /**
     * @return View
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param mixed $engine
     */
    public function setEngine($engine): void
    {
        $this->engine = $engine;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @return bool
     */
    public function hasReturn()
    {
        return $this->return !== null;
    }

    /**
     * @return null
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @param null $return
     */
    public function setReturn($return): void
    {
        $this->return = $return;
    }
}
