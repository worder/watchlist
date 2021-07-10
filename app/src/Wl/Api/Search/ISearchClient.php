<?php

namespace Wl\Api\Search;

use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchCollection;
use Wl\Api\Search\Result\ISearchItem;
use Wl\Api\Search\Result\ISearchItemDataContainer;

interface ISearchClient 
{
    public function getDatasourceName();

    /**
     * @return ISearchCollection [];
     */
    public function search(ISearchQuery $q): ISearchCollection;

    public function createItem(ISearchItemDataContainer $data): ISearchItem;
    public function createCollection(array $items, ISearchQuery $q): ISearchCollection;

    public function getMediaDetails($mediaId, $mediaType): ISearchItem;
}