<?php

namespace Wl\Media;
interface IMedia
{
    public function getReleaseDate();

    public function getOrigLocalization(): IMediaLocalization;
    public function getLocalization($locale): IMediaLocalization;
    public function hasLocalization($locale);

    // datasource related
    public function getDatasourceName();
    public function getDatasourceSnapshot();

    // public function getAssetsCollection(); // associated posters and stuff TODO
}
