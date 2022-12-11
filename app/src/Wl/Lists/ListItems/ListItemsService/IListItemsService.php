<?php

namespace Wl\Lists\ListItems\ListItemsService;

use Wl\Lists\ListItems\IListItems;

interface IListItemsService
{
    public function getListItems($listId, $locale, $limit, $offset): IListItems;

    public function addListItem(int $listId, string $api, int $mediaId, int $initialStatus, string $date, int $userId): int;
    public function deleteListItem($itemid);

    public function addListItemStatus(int $itemId, string $date, int $type, $value, int $userId): int;
    public function addListFeature(int $inteId, int $type, $value, int $userId): int;
}
