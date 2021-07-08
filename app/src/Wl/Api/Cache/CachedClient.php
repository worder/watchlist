<?php

namespace Wl\Api\Cache;

use Wl\Api\Seaech\ISearchClient;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Cache\ICache;

class CachedClient implements ISearchClient
{
    public function __construct(ICache $cache, ISearchClient $client)
    {
        
    }


    public function search(ISearchQuery $q)
    {
        
    }
}