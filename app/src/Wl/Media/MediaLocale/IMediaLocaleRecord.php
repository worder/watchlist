<?php

namespace Wl\Media\MediaLocale;

interface IMediaLocaleRecord extends IMediaLocale
{
    public function getMediaId(): ?int;
    public function setMediaId(int $id): void;

    public function getAdded(): string;
    public function setAdded(string $date): void;

    public function getUpdated(): string;
    public function setUpdated(string $date): void;
}