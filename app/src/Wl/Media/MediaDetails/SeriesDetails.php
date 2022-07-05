<?php

namespace Wl\Media\MediaDetails;

use Wl\Media\IMediaLocalization;

class SeriesDetails implements ISeriesDetails
{
    private $seasonsNumber;
    private $seasons;

    public function __construct($seasonsNumber)
    {
        $this->seasonsNumber = $seasonsNumber;
    }

    public function getSeasonDetails($number): ?ISeasonDetails
    {
        if (isset($seasons[$number])) {
            return $this->seasons[$number];
        }
    }

    public function addSeason(ISeasonDetails $season)
    {
        $this->seasons[$season->getSeasonNumber()] = $season;
    }

    public function getSeasonsNumber()
    {
        return $this->seasonsNumber;
    }
}