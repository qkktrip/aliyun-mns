<?php


namespace AliyunMNS\Support;

use ArrayAccess;

class Collection implements ArrayAccess
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function has($key)
    {
        return !is_null(Arr::get($this->items, $key));
    }

    public function set($key, $value)
    {
        Arr::set($this->items, $key, $value);
    }

    public function get($key, $default = null)
    {
        return Arr::get($this->items, $key, $default);

    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->get($offset) : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset,$value);
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }


}