<?php

namespace Wl\Lists\ListItems;

use Wl\Lists\ListItems\ListItemFeature\IListItemFeatures;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatuses;
use Wl\Media\MediaLocale\IMediaLocaleRecord;

interface IListItem 
{  
    public function getId();
    public function getMediaLocale(): IMediaLocaleRecord;
    public function getStatuses(): IListItemStatuses;
    public function getFeatures(): IListItemFeatures;
}