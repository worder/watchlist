<?php

namespace Wl\Media;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\Details\IDetails;

interface IMediaLocale
{
    public function getId();
    public function getMedia(): ?IMedia;
    
    // deprecated, better use whole media as atom
    // public function getLocalization($locale = 'en'): IMediaLocalization;
    // public function hasLocalization($locale);
    // public function getOriginalLocale();
    // to:
    public function getMediaType();
    public function getLocale();
    public function getTitle();
    public function getOverview();
    public function getReleaseDate();

    // datasource related
    // public function getMediaId(); // media id in datasource
    public function getDataContainer(): IDataContainer;

    public function getDetails(): ?IDetails;
    public function getAssets(): ?IAssets;
}
