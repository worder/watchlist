<?php

namespace Wl\Api\Data\DataAdapter;

use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Media\IMedia;

interface IDataAdapter
{
    public function getMedia(IDataContainer $container): IMedia;
}