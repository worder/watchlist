<?php

namespace Wl\Utils\Iterator;

use \Iterator;

abstract class AIterator implements Iterator
{
    private $position = 0;

    public function current()
    {
        return $this->getStorage()[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->getStorage()[$this->position]);
    }

    abstract protected function getStorage();
}
