<?php

namespace Wl\Media;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\Details\IDetails;

interface IMediaLocale
{
    public function getMedia(): ?IMedia;
    public function setMedia(IMedia $media): void;

    public function getDataContainer(): ?IDataContainer;
    public function setDataContainer(IDataContainer $container): void;

    public function getLocale(): string;
    public function setLocale(string $locale): void;

    public function getTitle(): string;
    public function setTitle(string $title): void;

    public function getOverview(): string;
    public function setOverview(string $overview): void;

    public function getDetails(): ?IDetails;
    public function setDetails(IDetails $details): void;

    public function getAssets(): ?IAssets;
    public function setAssets(IAssets $assets): void;
}
