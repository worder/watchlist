<?php

namespace Wl\Api\Search\Result;

use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Api\Data\DataContainer\IDataContainersCollection;

interface ISearchResult extends IDataContainersCollection
{
    public function getPages();
    public function getPage();
    public function getCount();
}