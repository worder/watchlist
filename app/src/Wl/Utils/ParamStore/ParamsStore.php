<?php

namespace Wl\Utils\ParamStore;

use Wl\Utils\Iterator\AIterator;

class ParamsStore extends AIterator implements IParamStore
{
    private $storage;

    public function __construct(array $data)
    {
        $this->storage = $data;
    }

    public function getStorage()
    {
        return $this->storage;
    }

    public function has($key)
    {
        return isset($this->storage[$key]);
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return $key;
        }
    }

    public function getAll()
    {
        return $this->storage;
    }
}