<?php

namespace Wl\Api\Search\Result;

class SearchItemDataContainer implements ISearchItemDataContainer
{
    private $data;
    private $isCached;
    private $cacheExpirationTime;


    public function __construct($rawData, $isCached = false, $cacheExpirationTime = 0)
    {
        $this->data = $rawData;
        $this->isCached = $isCached;
        $this->cacheExpirationTime = $cacheExpirationTime;
    }

    public function getDatasourceSnapshot()
    {
        return $this->data;
    }

    public function getCacheExpirationTime()
    {
        return $this->cacheExpirationTime;
    }

    public function isCached()
    {
        return $this->isCached;
    }
}