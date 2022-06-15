<?php

namespace Wl\Api\Search\Result;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\DataContainer\IDataContainersCollection;

interface ISearchResult extends IDataContainersCollection
{
    public function getPages();
    public function getPage();
    public function getTotal();
}