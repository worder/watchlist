<?php

namespace Wl\Media;

class Media implements IMedia
{
    private $datasourceName;
    private $datasourceSnapshot;
    
    private $mediaType;
    private $releaseDate;
    
    private $origLocale;
    private $locales = [];


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

    public function getOrigLocalization(): IMediaLocalization
    {
        return $this->origLocale;
    }

    public function setOriginalLocalization(IMediaLocalization $l10n)
    {
        $this->origLocale = $l10n;
    }

    public function hasLocalization($locale)
    {
        return isset($this->locales[$locale]);
    }

    public function getLocalization($locale): IMediaLocalization
    {
        return $this->locales[$locale];
    }

    public function addLocalization($l10n)
    {
        if (!$this->hasLocalization($l10n->getLocale())) {
            $this->locales[] = $l10n;
        }
    }

    public function getDatasourceName()
    {
        return $this->datasourceName;
    }

    public function setDatasourceName($name) 
    {
        $this->datasourceName = $name;
    }

    public function getDatasourceSnapshot()
    {
        return $this->datasourceSnapshot;
    }

    public function setDatasourceSnapshot($data)
    {
        $this->datasourceSnapshot = $data;
    }
}
