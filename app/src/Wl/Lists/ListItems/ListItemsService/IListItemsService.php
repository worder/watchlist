<?php

namespace Wl\Lists\ListItems\ListItemsService;

use Wl\Lists\ListItems\IListItems;

interface IListItemsService
{
    public function getListItems(int $listId, string $locale, int $limit, int $offset): IListItems;

    public function addListItem(int $listId, string $api, int $mediaId): int;
    public function deleteListItem($itemid);

    public function addListItemStatus(int $itemId, int $type, int $userId, string $date, $value = null): int;
    
    public function addListFeature(int $inteId, int $type, $value, int $userId): int;

    public function getUserMainPageItems(int $userId, string $locale, int $offset, int $limit): IListItems;
}
