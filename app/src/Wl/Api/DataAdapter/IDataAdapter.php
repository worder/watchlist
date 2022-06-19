<?php

namespace Wl\Api\DataAdapter;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\IMedia;
use Wl\Media\IMediaLocale;

interface IDataAdapter
{
    public function getMedia(IDataContainer $container): IMedia;
    public function getMediaLocale(IDataContainer $container): IMediaLocale;
}