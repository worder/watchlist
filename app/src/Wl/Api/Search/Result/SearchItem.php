<?php

namespace Wl\Api\Search\Result;

use Wl\Media\Media;

class SearchItem extends Media implements ISearchItem
{
    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
