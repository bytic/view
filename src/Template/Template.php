<?php

declare(strict_types=1);

namespace Nip\View\Template;

use Nip\View\View;
use function array_key_exists;
use function is_array;
use function is_string;

/**
 * Class Template.
 *
 * @property View $engine
 */
class Template extends \League\Plates\Template\Template
{
    /**
     * {@inheritDoc}
     */
    public function render($data = []): ?string
    {
        if (!is_string($data)) {
            return parent::render($data);
        }

        if (isset($this->sections[$data])) {
            return $this->section($data);
        }

        return $this->fetch($data);
    }

    /**
     * Determine if a piece of data is bound.
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get a piece of bound data to the view.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->with($key, $value);
    }

    /**
     * Unset a piece of data from the view.
     *
     * @param string $key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * @return mixed|null
     */
    public function &__get($key)
    {
        $var = $this->get($key);

        return $var;
    }

    /**
     * @return $this
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param string $name
     * @param null $default
     *
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return $default;
        }
    }

    /**
     * @return bool
     */
    public function has(string $name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @param null $value
     *
     * @return $this
     */
    public function with($key, $value = null)
    {
        $data = (is_array($key)) ? $key : [$key => $value];
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @param string|array $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * @param string $name
     * @param string $appended
     *
     * @return $this
     */
    public function append($name, $appended)
    {
        $value = $this->has($name) ? $this->get($name) : '';
        $value .= $appended;

        return $this->set($name, $value);
    }

    /**
     * Assigns variables in bulk in the current scope.
     *
     * @param array $array
     *
     * @return $this
     */
    public function assign($array = [])
    {
        foreach ($array as $key => $value) {
            if (is_string($key)) {
                $this->set($key, $value);
            }
        }

        return $this;
    }

    /**
     * @return View
     */
    public function getEngine(): View
    {
        return $this->engine;
    }
}
