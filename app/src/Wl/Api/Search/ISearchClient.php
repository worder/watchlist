<?php

namespace Wl\Api\Seaech;

use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchCollection;

interface ISearchClient 
{
    /**
     * @return ISearchCollection [];
     */
    public function search(ISearchQuery $q);
}