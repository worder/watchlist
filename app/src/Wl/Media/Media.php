<?php

namespace Wl\Media;

use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\Details\IDetails;

class Media implements IMedia
{
    private $dataContainer;
    private $mediaId;
    
    private $mediaType;
    private $releaseDate;
    
    private $locales = [];
    private $origLocale;

    // private $seasonsCount;
    // private $episodesCount;
    // private $seasonNumber;

    private ?IDetails $details;
    private ?IAssets $assets;

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
        $this->mediaType = $type;
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

    public function getOriginalLocale()
    {
        return $this->origLocale;
    }

    public function setOriginalLocale($locale)
    {
        $this->origLocale = $locale;
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

    public function getDetails(): ?IDetails
    {
        return $this->details;
    }

    public function setDetails(IDetails $details)
    {
        $this->details = $details;
    }

    public function getAssets(): ?IAssets
    {
        return $this->assets;
    }

    public function setAssets(IAssets $assets): void
    {
        $this->assets = $assets;
    }
}
