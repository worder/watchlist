<?php

namespace Wl\Media;

class MediaRecord extends Media implements IMediaRecord
{
    private $id = null;
    private $added = '';
    private $updated = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAdded(): string
    {
        return $this->added;
    }

    public function setAdded($added): void
    {
        $this->added = $added;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }

    public function setUpdated($updated): void
    {
        $this->updated = $updated;
    }
}