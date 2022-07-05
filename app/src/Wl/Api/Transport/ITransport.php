<?php

namespace Wl\Api\Transport;

use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchResult;

interface ITransport
{
    public function getApiId();
    public function getSupportedMediaTypes(): array;

    public function search(ISearchQuery $q): ISearchResult;
    public function getMediaDetails($mediaId, $mediaType = null): IApiDataContainer;
}