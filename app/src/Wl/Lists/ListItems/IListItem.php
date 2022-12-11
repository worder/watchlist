<?php

namespace Wl\Lists\ListItems;

use Wl\Lists\ListItems\ListItemFeature\IListItemFeatures;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatuses;
use Wl\Media\MediaLocale\IMediaLocaleRecord;

interface IListItem 
{  
    public function getId(): int;
    public function getListId(): int;
    
    public function getMediaLocale(): IMediaLocaleRecord;
    public function getCurrentStatus(): IListItemStatus;
    // public function getStatuses(): IListItemStatuses;
    // public function getFeatures(): IListItemFeatures;
}