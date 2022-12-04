<?php

namespace Wl\Lists\ListItems\ListItemStatus;

interface IListItemStatuses 
{
    /**
     * @return IListItemStatuses[]
     */
    public function getAll(): array;
    public function getCurrentStatus(): IListItemStatus;
}