<?php

namespace Wl\Media\MediaService;

use Wl\Media\IMedia;
use Wl\Media\IMediaLocale;
use Wl\Media\IMediaLocaleRecord;
use Wl\Media\IMediaRecord;

interface IMediaService 
{
    public function addMedia(IMedia $media): IMediaRecord;
    public function addMediaLocale(IMediaLocale $locale): IMediaLocaleRecord;
    // public function updateMediaLocale(MediaLocale $locale);

    public function getMediaById($id): IMediaRecord;
    public function getMediaByApiId($api, $apiMediaId): ?IMediaRecord;

    public function getMediaLocaleById($id): IMediaLocaleRecord;
}