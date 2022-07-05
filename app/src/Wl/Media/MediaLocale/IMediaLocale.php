<?php

namespace Wl\Media\MediaLocale;

use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\IMedia;
use Wl\Media\MediaDetails\IMediaDetails;

interface IMediaLocale
{
    public function getMedia(): ?IMedia;
    public function setMedia(IMedia $media): void;

    public function getDataContainer(): ?IApiDataContainer;
    public function setDataContainer(IApiDataContainer $container): void;

    public function getLocale(): string;
    public function setLocale(string $locale): void;

    public function getTitle(): string;
    public function setTitle(string $title): void;

    public function getOverview(): string;
    public function setOverview(string $overview): void;

    public function getDetails(): ?IMediaDetails;
    public function setDetails(IMediaDetails $details): void;

    public function getAssets(): ?IAssets;
    public function setAssets(IAssets $assets): void;
}
