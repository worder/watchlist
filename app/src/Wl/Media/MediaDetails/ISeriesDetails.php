<?php

namespace Wl\Media\MediaDetails;

interface ISeriesDetails extends IMediaDetails
{
    public function getSeasonsNumber();
    public function getSeasonDetails($number): ?ISeasonDetails;
}