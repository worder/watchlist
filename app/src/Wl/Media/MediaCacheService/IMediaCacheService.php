<?php

namespace Wl\Media\MediaCacheService;

use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Media\MediaLocale\IMediaLocaleRecord;

interface IMediaCacheService 
{
    public function isInCache($api, $mediaId, $locale): bool;
    public function getFromCache($api, $mediaId, $locale): ?IMediaLocaleRecord;
    public function deleteFromCache($api, $mediaId, $locale): void;
    public function addToCache(string $api, string $mediaId, string $locale, string $title, IApiDataContainer $data): void;
}