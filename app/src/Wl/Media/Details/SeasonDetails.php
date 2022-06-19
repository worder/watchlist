<?php

namespace Wl\Media\Details;

use Wl\Media\IMediaLocalization;

class SeasonDetails implements ISeasonDetails
{
    private $episodesNumber;
    private $seasonNumber = 0;
    private string $title;
    private string $overview;

    public function __construct($seasonNumber, $episodesNumber)
    {
        $this->episodesNumber = $episodesNumber;
        $this->seasonNumber = $seasonNumber;
    }

    public function getEpisodesNumber()
    {
        return $this->episodesNumber;
    }

    public function getSeasonNumber()
    {
        return $this->seasonNumber;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getOverview()
    {
        return $this->overview;
    }

    public function setOverview($overview)
    {
        $this->overview = $overview;
    }
}