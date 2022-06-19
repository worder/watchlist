<?php

namespace Wl\Media;

interface IMedia
{
    public function getId();
    public function getApiMediaId();
    public function getApi();

    public function getMediaType();
    public function getReleaseDate();
    public function getOriginalTitle();

    public function getLocale($locale): ?IMediaLocale;
    public function getOriginalLocale(): ?IMediaLocale;
    public function hasLocale($locale): bool;
}