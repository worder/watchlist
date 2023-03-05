<?php

namespace Wl\Media\MediaLocale;

use Wl\Utils\Date\IDate;

interface IMediaLocaleRecord extends IMediaLocale
{
    // public function getMediaId(): ?int;
    // public function setMediaId(int $id): void;

    public function getAdded(): ?IDate;
    public function setAdded(IDate $date): void;

    public function getUpdated(): ?IDate;
    public function setUpdated(IDate $date): void;
}