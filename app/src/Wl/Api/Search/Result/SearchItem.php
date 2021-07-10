<?php

namespace Wl\Api\Search\Result;

use Wl\Media\Media;

class SearchItem extends Media implements ISearchItem
{
    private $dataContainer;

    public function __construct(ISearchItemDataContainer $datacon)
    {
        $this->dataContainer = $datacon;
    }

    public function isCached()
    {
        return $this->dataContainer->isCached();
    }

   
    public function getCacheExpirationTime()
    {
        return $this->dataContainer->getCacheExpirationTime();
    }

    public function getDatasourceSnapshot()
    {
        return $this->dataContainer->getDatasourceSnapshot();
    }
}
