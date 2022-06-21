<?php

namespace Wl\Api\DataAdapter;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\IMedia;
use Wl\Media\IMediaLocale;

interface IDataAdapter
{
    public function buildMedia(IMedia $media, IDataContainer $container): IMedia;
    public function buildMediaLocale(IMediaLocale $locale, IDataContainer $container): IMediaLocale;
}