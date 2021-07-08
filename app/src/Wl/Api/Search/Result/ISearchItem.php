<?php

namespace Wl\Api\Search\Result;

use Wl\Media\IMedia;

interface ISearchItem extends IMedia
{
    public function getId();
}