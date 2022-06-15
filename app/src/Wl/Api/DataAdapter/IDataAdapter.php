<?php

namespace Wl\Api\DataAdapter;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\IMedia;

interface IDataAdapter
{
    public function getMedia(IDataContainer $container): IMedia;
}