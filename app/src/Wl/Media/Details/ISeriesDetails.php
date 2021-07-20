<?php

namespace Wl\Media\Details;

interface ISeriesDetails extends IDetails
{
    public function getSeasonsNumber();
    public function getSeasonDetails($number): ?ISeasonDetails;
}