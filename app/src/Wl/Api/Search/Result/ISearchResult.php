<?php

namespace Wl\Api\Search\Result;

use Wl\Media\ApiDataContainer\IApiDataContainersCollection;

interface ISearchResult extends IApiDataContainersCollection
{
    public function getPages();
    public function getPage();
    public function getTotal();
}