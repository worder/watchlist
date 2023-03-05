<?php

namespace Wl\Media\MediaLocale;

use Wl\Utils\Date\IDate;

class MediaLocaleRecord extends MediaLocale implements IMediaLocaleRecord
{
    // private $mediaId = null;
    private $added = null;
    private $updated = null;

    // public function getMediaId(): ?int
    // {
    //     return $this->mediaId;
    // }

    // public function setMediaId($id): void
    // {
    //     $this->mediaId = $id;
    // }

    public function getAdded(): ?IDate
    {
        return $this->added;
    }

    public function setAdded(IDate $date): void
    {
        $this->added = $date;
    }

    public function getUpdated(): ?IDate
    {
        return $this->updated;
    }

    public function setUpdated(IDate $date): void
    {
        $this->updated = $date;
    }
}