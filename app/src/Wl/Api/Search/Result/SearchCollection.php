<?php

namespace Wl\Api\Search\Result;

use Iterator;
use Wl\Utils\Iterator\AIterator;

class SearchCollection extends AIterator implements ISearchCollection, Iterator
{
    private $pages = 0;
    private $page = 0;

    private $items = [];

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getCount()
    {
        return count($this->items);
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function addItem(ISearchItem $item)
    {
        $this->items[] = $item;
    }

    protected function getStorage()
    {
        return $this->items;
    }
}
