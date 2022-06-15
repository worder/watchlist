<?php

namespace Wl\Api\Search\Result;

use Iterator;
use Traversable;
use Wl\Media\DataContainer\IDataContainer;
use Wl\Utils\Iterator\AIterator;

class SearchResult extends AIterator implements ISearchResult, Iterator
{
    private $pages = 0;
    private $page = 0;
    private $total = 0;

    private $items;

    public function __construct($containers = [])
    {
        $this->setContainers($containers);
    }

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

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($number)
    {
        $this->total = $number;
    }

    public function getContainers()
    {
        return $this->items;
    }

    public function setContainers($items)
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->addContainer($item);
        }
    }

    public function addContainer(IDataContainer $item)
    {
        $this->items[] = $item;
    }

    protected function getStorage()
    {
        return $this->items;
    }
}
