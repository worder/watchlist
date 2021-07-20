<?php

namespace Wl\Media;

use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Media\Details\IDetails;

interface IMedia
{
    public function getMediaType();
    public function getReleaseDate();

    public function getLocalization($locale = 'en'): IMediaLocalization;
    public function hasLocalization($locale);
    public function getOriginalLocale();

    // datasource related
    public function getMediaId(); // media id in datasource
    public function getDataContainer(): IDataContainer;

    public function getDetails(): ?IDetails;
    // public function getAssets();
}
