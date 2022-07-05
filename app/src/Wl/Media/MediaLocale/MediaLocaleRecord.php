<?php

namespace Wl\Media\MediaLocale;

class MediaLocaleRecord extends MediaLocale implements IMediaLocaleRecord
{
    private $mediaId = null;
    private $added = '';
    private $updated = '';

    public function getMediaId(): ?int
    {
        return $this->mediaId;
    }

    public function setMediaId($id): void
    {
        $this->mediaId = $id;
    }

    public function getAdded(): string
    {
        return $this->added;
    }

    public function setAdded($date): void
    {
        $this->adedd = $date;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }

    public function setUpdated($date): void
    {
        $this->updated = $date;
    }
}