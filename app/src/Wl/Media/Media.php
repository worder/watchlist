<?php

namespace Wl\Media;

class Media implements IMedia
{
    private $datasourceName;
    private $datasourceSnapshot;
    
    private $releaseDate;
    
    private $origLocale;
    private $locales = [];


    public function __construct()
    {
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function getOrigLocalization(): IMediaLocalization
    {
        return $this->origLocale;
    }

    public function hasLocalization($locale)
    {
        return isset($this->locales[$locale]);
    }

    public function getLocalization($locale): IMediaLocalization
    {
        return $this->locales[$locale];
    }

    public function getDatasourceName()
    {
        return $this->datasourceName;
    }

    public function getDatasourceSnapshot()
    {
        return $this->datasourceSnapshot;
    }
}
