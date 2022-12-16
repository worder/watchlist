<?php

namespace Wl\Lists\ListItems\ListItemStatus;

class ListItemStatusValidator 
{
    public function isValidStatus(int $type)
    {
        return in_array($type, ListItemStatus::getAllTypes());
    }
}