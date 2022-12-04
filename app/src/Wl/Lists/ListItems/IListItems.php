<?php

namespace Wl\Lists\ListItems;

interface IListItems 
{
    /**
     * @return IListItem[]
     */
    public function getItems(): array;

    public function getTotal(): int;
    public function getOffset(): int;
    public function getLimit(): int;
}