<?php

namespace Wl\Api\DataAdapter;

use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Media\IMedia;
use Wl\Media\MediaLocale\IMediaLocale;

interface IDataAdapter
{
    public function buildMedia(IMedia $media, IApiDataContainer $container): IMedia;
    public function buildMediaLocale(IMediaLocale $locale, IApiDataContainer $container): IMediaLocale;
}