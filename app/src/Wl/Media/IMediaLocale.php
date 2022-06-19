<?php

namespace Wl\Media;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\Details\IDetails;

interface IMediaLocale
{
    public function getId();

    public function getMedia(): ?IMedia;
    public function getDataContainer(): IDataContainer;
    
    public function getLocale();
    public function getTitle();
    public function getOverview();

    public function getDetails(): ?IDetails;
    public function getAssets(): ?IAssets;
}
