<?php

namespace Wl\Media;

class MediaLocalization implements IMediaLocalization
{
    private $locale;
    private $language;
    private $title;
    private $overview;

    public function __construct($locale = null, $title = null, $overview = null)
    {
        if ($locale) {
            $this->setLocale($locale);
        }
        if ($title) {
            $this->setTitle($title);
        }
        if ($overview) {
            $this->setOverview($overview);
        }
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($lang)
    {
        $this->language = $lang;
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

    public function setOverview($val)
    {
        $this->overview = $val;
    }
}