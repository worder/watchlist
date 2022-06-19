<?php

namespace Wl\Media;

class Media implements IMedia
{
    private int $id;
    private string $api;
    private string $apiMediaId;
    private string $mediaType;
    private string $releaseDate;
    private string $originalLocale;
    private string $originalTitle;
    private array $locales;

    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getApi()
    {
        return $this->api;
    }
    public function setApi($api)
    {
        $this->api = $api;
    }

    public function getApiMediaId()
    {
        return $this->apiMediaId;
    }
    public function setApiMediaId(string $id)
    {
        $this->apiMediaId = $id;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }
    public function setMediaType(string $type)
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

    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }
    public function setOriginalTitle($title)
    {
        $this->originalTitle = $title;
    }

    public function getLocale($locale): ?IMediaLocale
    {
        if ($this->hasLocale($locale)) {
            return $this->locales[$locale];
        }

        return null;
    }

    public function getOriginalLocale(): ?IMediaLocale
    {
        if ($this->hasLocale($this->originalLocale)) {
            return $this->getLocale($this->originalLocale);
        }

        return null;
    }

    public function setOriginalLocale(string $cc)
    {
        $this->originalLocale = $cc;
    }

    public function hasLocale($locale): bool
    {
        return isset($this->locales[$locale]);
    }

    public function addLocale(IMediaLocale $mediaLocale)
    {
        $this->locals[$mediaLocale->getLocale()] = $mediaLocale;
    }
}
