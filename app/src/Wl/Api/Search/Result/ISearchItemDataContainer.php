<?php

namespace Wl\Api\Search\Result;

interface ISearchItemDataContainer
{
    public function getDatasourceSnapshot();
    public function isCached();
    public function getCacheExpirationTime();
}