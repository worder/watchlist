<?php

namespace Wl\Api\Search\Result;

class SearchItem implements ISearchItem
{
    // private $origTitle;
    // private $origLanguage;

    // private $title;
    // private $overview;
    private $releaseDate;

    private $localizedData;

    private $datasourceName;
    private $datasourceSnapshot;

    private $origLocale;
    private $locales = [];


    public function __construct()
    {

    }

    // public function getOriginalTitle()
    // {
    //     return $this->origTitle;
    // }

    // public function getOriginalLanguage()
    // {
    //     return $this->origLanguage;
    // }

    public function getOrigLocale()
    {
        return $this->origLocale;
    }

    public function hasLocale($locale)
    {
        return isset($this->locales[$locale]);
    }

    public function getLocale($locale)
    {
        return $this->locales[$locale];
    }

    

}