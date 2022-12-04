<?php

namespace Wl\Lists\ListItems\ListItemsService;

use Wl\Lists\ListItems\IListItem;
use Wl\Lists\ListItems\IListItems;
use Wl\Lists\ListItems\ListItemFeature\IListItemFeature;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;

interface IListItemsService 
{
    public function getListItems($listId, $limit, $offset): IListItems;
    // public function getListItemStatuses($itemId);
    // public function getListItemFeatures($itemId);

    public function addListItem(IListItem $item);
    public function deleteListItem($itemid);
    
    public function addListItemStatus(IListItemStatus $status);
    public function addListFeature(IListItemFeature $feature);


}