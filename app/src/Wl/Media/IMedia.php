<?php

namespace Wl\Media;
interface IMedia
{
    public function getMediaType();
    public function getReleaseDate();

    public function getOrigLocalization(): IMediaLocalization;
    public function getLocalization($locale): IMediaLocalization;
    public function hasLocalization($locale);

    // datasource related
    public function getDatasourceName();
    public function getDatasourceSnapshot();
    public function getMediaId(); // media id in datasource

    // public function getAssetsCollection(); // associated posters and stuff TODO
}
