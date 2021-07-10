<?php

namespace Wl\Datasource\KeyValue;

class KeyDecoratedStorage implements IStorage
{
    private $prefix;
    private $backend;

    public function __construct(IStorage $backend, $prefix)
    {
        $this->backend = $backend;
        $this->prefix = $prefix;
    }

    public function getExpirationTime($key)
    {
        return $this->backend->getExpirationTime($this->prefix . $key);
    }

    public function get($key)
    {
        return $this->backend->get($this->prefix . $key);
    }

    public function add($key, $value, $expire = 0)
    {
        return $this->backend->add($this->prefix . $key, $value, $expire);
    }

    public function set($key, $value, $expire = 0)
    {
        return $this->backend->set($this->prefix . $key, $value, $expire);
    }

    public function delete($key)
    {
        return $this->backend->delete($this->prefix . $key);
    }
}