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

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->getStorage()[$this->position]);
    }

    abstract protected function getStorage();
}
