<?php

namespace Wl\Media\Details;

use Wl\Media\IMediaLocalization;

class SeasonDetails implements ISeasonDetails
{
    private $episodesNumber;
    private $seasonNumber = 0;
    private $localizations = [];

    public function __construct($seasonNumber, $episodesNumber)
    {
        $this->episodesNumber = $episodesNumber;
        $this->seasonNumber = $seasonNumber;
    }

    public function getEpisodesNumber()
    {
        return $this->episodesNumber;
    }

    public function getLocalization($locale): IMediaLocalization
    {
        return $this->seasonNumber;
    }

    public function addLocalization(IMediaLocalization $l10n)
    {
        $this->localizations[$l10n->getLocale()] = $l10n;
    }

    public function getSeasonNumber()
    {
        return $this->seasonNumber;
    }
}