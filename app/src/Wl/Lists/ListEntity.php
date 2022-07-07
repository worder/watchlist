<?php

namespace Wl\Lists;

class ListEntity implements IList
{
    private $id = null;
    private $ownerId;
    private $title;
    private $desc;
    private $added = '';
    private $updated = '';

    public function __construct()
    {
    }

    public function setId($id): ListEntity
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDesc($desc): ListEntity
    {
        $this->desc = $desc;
        return $this;
    }
    public function getDesc(): string
    {
        return $this->desc;
    }

    public function setTitle($title): ListEntity
    {
        $this->title = $title;
        return $this;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function setOwnerId(int $ownerId): ListEntity
    {
        $this->ownerId = $ownerId;
        return $this;
    }
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function getUpdated(): string
    {
        return $this->updated;
    }
    public function setUpdated($date): ListEntity
    {
        $this->updated = $date;
        return $this;
    }

    public function getAdded(): string
    {
        return $this->added;
    }
    public function setAdded($date): ListEntity
    {
        $this->added = $date;
        return $this;
    }
}
