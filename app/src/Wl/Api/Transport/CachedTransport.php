<?php

namespace Wl\Api\Transport;

use Wl\Api\Data\DataContainer\DataContainer;
use Wl\Api\Data\DataContainer\DataContainerCached;
use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchResult;
use Wl\Api\Search\Result\SearchResult;
use Wl\Api\Transport\ITransport;
use Wl\Datasource\KeyValue\IStorage;
use Wl\Datasource\KeyValue\KeyDecoratedStorage;

class CachedTransport implements ITransport
{
    private $backend;
    private $storage;

    public function __construct(IStorage $storage, ITransport $backend)
    {
        $this->backend = $backend;
        $this->storage = new KeyDecoratedStorage($storage, $backend->getApiId());
    }

    public function getApiId()
    {
        return $this->backend->getApiId();
    }

    public function getSupportedMediaTypes(): array
    {
        return $this->backend->getSupportedMediaTypes();
    }

    public function search(ISearchQuery $q): ISearchResult
    {
        $qHash = md5("{$q->getTerm()}.{$q->getMediaType()}.{$q->getPage()}.{$q->getLimit()}");

        $data = $this->storage->get($qHash);
        if ($data && ($data instanceof ISearchResult)) { // cache get
            return $data;
        }

        /** @var SearchResult */
        $result = $this->backend->search($q);
        $expire = 60 * 60 * 24;
        $cachedContainers = [];
        foreach ($result as $con) {
            $cachedCon = DataContainerCached::createFromContainer($con);
            $cachedCon->setCacheExpirationTime(\time() + $expire);
            $cachedContainers[] = $cachedCon;
        }
        $result->setContainers($cachedContainers);
        $this->storage->set($qHash, $result, $expire);
        return $result;
    }

    public function getMediaDetails($mediaId, $mediaType = null): IDataContainer
    {
        $qHash = md5("{$mediaId}.{$mediaType}");
        $cachedContainer = $this->storage->get($qHash);

        if ($cachedContainer && $cachedContainer instanceof IDataContainer) {
            return $cachedContainer;
        }

        $expire = 60 * 60 * 24;
        $cachedContainer = DataContainerCached::createFromContainer($this->backend->getMediaDetails($mediaId, $mediaType));
        $cachedContainer->setCacheExpirationTime(\time() + $expire);

        $this->storage->set($qHash, $cachedContainer, $expire);

        return $cachedContainer;
    }
}
