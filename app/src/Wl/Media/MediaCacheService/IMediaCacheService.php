<?php

namespace Wl\Media\MediaCacheService;

use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\MediaLocale\IMediaLocaleRecord;

interface IMediaCacheService 
{
    public function isInCache($api, $mediaId, $locale): bool;
    public function getFromCache($api, $mediaId, $locale): ?IMediaLocaleRecord;
    public function deleteFromCache($api, $mediaId, $locale): void;
    public function addToCache(IMediaLocale $locale): void;

    public function refetch($api, $mediaId);
}