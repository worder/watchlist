<?php

namespace Wl\Media;

use Wl\Api\Data\DataContainer\IDataContainer;

class Media implements IMedia
{
    private $dataContainer;
    private $mediaId;
    
    private $mediaType;
    private $releaseDate;
    
    private $locales = [];

    private $seasonsCount;
    private $episodesCount;
    private $seasonNumber;

    public function __construct(IDataContainer $dataContainer)
    {
        $this->dataContainer = $dataContainer;
    }


    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function setMediaType($type)
    {
        return $this->mediaType;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function setReleaseDate($date)
    {
        $this->releaseDate = $date;
    }

    public function hasLocalization($locale)
    {
        return isset($this->locales[$locale]);
    }

    public function getLocalization($locale = 'en'): IMediaLocalization
    {
        if ($this->hasLocalization($locale)) {
            return $this->locales[$locale];
        } else {
            return new MediaLocalization($locale, '_' . $locale . '_nodata_');
        }
    }

    public function addLocalization($l10n)
    {
        if (!$this->hasLocalization($l10n->getLocale())) {
            $this->locales[$l10n->getLocale()] = $l10n;
        }
    }

    public function getDataContainer(): IDataContainer
    {
        return $this->dataContainer;
    }

    public function getMediaId()
    {
        return $this->mediaId;
    }

    public function setMediaId($id)
    {
        $this->mediaId = $id;
    }

    public function getSeasonsCount()
    {
        return $this->seasonsCount;
    }

    public function setSeasonsCount($count)
    {
        $this->seasonsCount = $count;
    }

    public function getSeasonNumber()
    {
        return $this->seasonNumber;
    }

    public function setSeasonNumber($number)
    {
        $this->seasonNumber = $number;
    }

    public function getEpisodesCount()
    {
        return $this->episodesCount;
    }

    public function setEpisodesCount($count)
    {
        $this->episodesCount = $count;
    }
}
