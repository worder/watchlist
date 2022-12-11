<?php

namespace Wl\Lists\ListItems;

use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;
use Wl\Media\MediaLocale\IMediaLocaleRecord;

class ListItem implements IListItem
{
    private $id;
    private $listId;
    private $mediaLocale;
    private $status;

    public function __construct($id, $listId, IMediaLocaleRecord $mediaLocale, IListItemStatus $status)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->mediaLocale = $mediaLocale;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getListId(): int
    {
        return $this->listId;
    }

    public function getMediaLocale(): IMediaLocaleRecord
    {
        return $this->mediaLocale;
    }

    public function getCurrentStatus(): IListItemStatus
    {
        return $this->status;
    }
}
