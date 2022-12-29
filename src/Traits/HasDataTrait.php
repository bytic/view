<?php

declare(strict_types=1);

namespace Nip\View\Traits;

use function array_key_exists;
use function is_array;
use function is_string;

/**
 * Trait HasDataTrait.
 */
trait HasDataTrait
{
    /**
     * Determine if a piece of data is bound.
     *
     * @param string $key
     */
    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get a piece of bound data to the view.
     *
     * @param string $key
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
     */
    public function offsetSet($key, $value): void
    {
        $this->with($key, $value);
    }

    /**
     * Unset a piece of data from the view.
     *
     * @param string $key
     */
    public function offsetUnset($key): void
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
        $data = $this->getData();
        if (isset($data[$name])) {
            return $data[$name];
        } else {
            return $default;
        }
    }

    /**
     * @return bool
     */
    public function has(string $name)
    {
        $data = $this->getData();

        return isset($data[$name]);
    }

    /**
     * @param null $value
     *
     * @return $this
     */
    public function with($key, $value = null)
    {
        $data = (is_array($key)) ? $key : [$key => $value];
        $this->addData($data);

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
        $this->data->add([$key => $value]);

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
}
