<?php

declare(strict_types=1);

namespace Nip\View\Helpers;

use Nip\Collections\AbstractCollection;
use Nip\View\Extensions\Helpers\HelperNotFoundException;
use Nip\View\View;
use function is_object;

/**
 * Class MethodsCollection.
 */
class HelpersCollection extends AbstractCollection
{
    protected static $instance = null;

    /**
     * @var View
     */
    protected $engine = null;

    /**
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
     * @return bool
     */
    public function hasHelper($name)
    {
        if (!$this->has($name)) {
            $this->initHelper($name);
        }

        return is_object($this->get($name, null));
    }

    public function initHelper($name)
    {
        try {
            $helper = HelpersFactory::create($this->getEngine(), $name);
        } catch (HelperNotFoundException $exception) {
            $helper = null;
        }
        $this->set($name, $helper);
    }

    public function getEngine(): View
    {
        return $this->engine;
    }

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
            static::$instance = new static();
        }

        return static::$instance;
    }
}
