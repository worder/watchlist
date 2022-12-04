<?php
// DEPRECATED, to be deleted
namespace Wl\Media\MediaService;

use Wl\Media\IMedia;
use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\MediaLocale\IMediaLocaleRecord;
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