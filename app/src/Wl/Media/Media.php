<?php

namespace Wl\Media;

class Media implements IMedia
{
    private string $api = '';
    private string $apiMediaId = '';
    private string $mediaType = '';
    private ?string $releaseDate = '';
    private string $originalLocale = '';
    private string $originalTitle = '';

    public function __construct()
    {
    }

    public function getApi(): string
    {
        return $this->api;
    }
    public function setApi($api): void
    {
        $this->api = $api;
    }

    public function getApiMediaId(): string
    {
        return $this->apiMediaId;
    }
    public function setApiMediaId(string $id): void
    {
        $this->apiMediaId = $id;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }
    public function setMediaType(string $type): void
    {
        $this->mediaType = $type;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate ?? null;
    }
    public function setReleaseDate($date): void
    {
        $this->releaseDate = $date;
    }

    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }
    public function setOriginalTitle($title): void
    {
        $this->originalTitle = $title;
    }

    public function setOriginalLocale(string $locale)
    {
        $this->originalLocale = $locale;
    }

    public function getOriginalLocale(): string
    {
        return $this->originalLocale;
    }
}
