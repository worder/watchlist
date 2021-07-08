<?php

namespace Wl\Media;

interface ISeriesSeason extends IMedia
{
    public function getSeriesMedia(): ISeries;
    
    public function getSeasonNumber();
    public function getSeasonTitle();
    public function getEpisodeCount();
    public function getFirstAirDate();
    public function getLastAirDate();
    public function isEnded();
}