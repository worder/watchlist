<?php

namespace Wl\Media;

interface IMedia
{
    public function getApiMediaId(): string;
    public function setApiMediaId(string $apiMediaId): void;
    public function getApi(): string;
    public function setApi(string $api): void;

    public function getMediaType(): string;
    public function setMediaType(string $type): void;

    public function getOriginalLocale(): string;
    public function setOriginalLocale(string $locale);

    public function getReleaseDate(): string;
    public function setReleaseDate(string $date): void;
    public function getOriginalTitle();
    public function setOriginalTitle(string $title): void;
    

    
}