<?php

namespace Wl\Media;

use Wl\Api\Data\DataContainer\IDataContainer;

interface IMedia
{
    public function getMediaType();
    public function getReleaseDate();

    public function getLocalization($locale = 'en'): IMediaLocalization;
    public function hasLocalization($locale);

    // datasource related
    public function getMediaId(); // media id in datasource
    public function getDataContainer(): IDataContainer;

    public function getSeasonsCount();
    public function getSeasonNumber();
    public function getEpisodesCount();

    // public function getDetails();
    // public function getAssets();
}
