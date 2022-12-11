<?php

namespace Wl\Lists\ListItems;

class ListItems implements IListItems
{
    private $items = [];
    private $limit;
    private $offset;
    private $total;

    public function __construct(int $limit, int $offset, int $total)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->total = $total;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(IListItem $item)
    {
        $this->items[] = $item;
    }

    public function getLimit(): int
    {
        return $this->limit;    
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}