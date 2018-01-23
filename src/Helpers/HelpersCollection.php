<?php

namespace Nip\View\Helpers;

use Nip\Collections\AbstractCollection;
use Nip\View;
use Nip\View\Extensions\Helpers\HelperNotFoundException;

/**
 * Class MethodsCollection
 * @package Nip\View\Methods
 */
class HelpersCollection extends AbstractCollection
{
    protected static $instance = null;

    /**
     * @var View
     */
    protected $engine = null;


    /**
     * @param $name
     * @return mixed
     */
    public function getHelper($name)
    {
        if (!$this->has($name)) {
            $this->initHelper($name);
        }

        return $this->get($name, null);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasHelper($name)
    {
        if (!$this->has($name)) {
            $this->initHelper($name);
        }

        return is_object($this->get($name, null));
    }

    /**
     * @param $name
     */
    public function initHelper($name)
    {
        try {
            $helper = HelpersFactory::create($this->getEngine(), $name);
        } catch (HelperNotFoundException $exception) {
            $helper = null;
        }
        $this->set($name, $helper);
    }

    /**
     * @return View
     */
    public function getEngine(): View
    {
        return $this->engine;
    }

    /**
     * @param View $engine
     */
    public function setEngine(View $engine): void
    {
        $this->engine = $engine;
    }

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}
