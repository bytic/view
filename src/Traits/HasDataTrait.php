<?php
declare(strict_types=1);

namespace Nip\View\Traits;

/**
 * Trait HasDataTrait
 * @package Nip\View\Traits
 */
trait HasDataTrait
{
    protected $data = [];

    /**
     * Determine if a piece of data is bound.
     *
     * @param string $key
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get a piece of bound data to the view.
     *
     * @param string $key
     * @return mixed
     */
    public function offsetGet($key): mixed
    {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->with($key, $value);
    }

    /**
     * Unset a piece of data from the view.
     *
     * @param string $key
     * @return void
     */
    public function offsetUnset($key): void
    {
        unset($this->data[$key]);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function &__get($key)
    {
        return $this->data[$key];
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function get($name, $default = null)
    {
        if ($this->has($name)) {
            return $this->data[$name];
        } else {
            return $default;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @param $key
     * @param null $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * @param string|array $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * @param string $name
     * @param string $appended
     * @return $this
     */
    public function append($name, $appended)
    {
        $value = $this->has($name) ? $this->get($name) : '';
        $value .= $appended;

        return $this->set($name, $value);
    }

    /**
     * Get the array of view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
