<?php

namespace Wl\Lists;

class ListEntity implements IList
{
    private $id;
    private $title;
    private $desc;

    public function __construct()
    {
    }

    public function setId($id): ListEntity
    {
        $this->id = $id;
        return $this;
    }
    public function getId(): int
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
}
