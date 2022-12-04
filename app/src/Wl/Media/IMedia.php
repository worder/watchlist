<?php

namespace Wl\Media;

interface IMedia
{
    public function getApiMediaId(): string;
    public function getApi(): string;

    public function getMediaType(): string;

    public function getOriginalLocale(): string;

    public function getReleaseDate(): string;
    public function getOriginalTitle();

    public function setApiMediaId(string $apiMediaId): void;
    public function setApi(string $api): void;
    public function setMediaType(string $type): void;
    public function setOriginalLocale(string $locale);
    public function setReleaseDate(string $date): void;
    public function setOriginalTitle(string $title): void;
}
