<?php

namespace Wl\Api\Transport;

use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchResult;
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
        $this->storage = new KeyDecoratedStorage($storage, $backend->getType());
    }

    public function getType()
    {
        return $this->backend->getType();
    }

    public function search(ISearchQuery $q): ISearchResult
    {
        $qHash = $q->getTerm() . ':' . $q->getPage() . ':' . $q->getLimit() . ':' . $q->getMediaType();

        $data = $this->storage->get($qHash);
        if ($data && ($data instanceof ISearchResult)) { // cache get
            return $data;
        } 
        
        $result = $this->backend->search($q);
        $expire = 60 * 60 * 24;
        foreach ($result as $con) {
            $con->setCacheExpirationTime(\time() + $expire);
        }
        $this->storage->add($qHash, $result, $expire);
        return $result;
    }

    public function getMediaDetails($mediaId, $mediaType = null): IDataContainer
    {
        return $this->backend->getMediaDetails($mediaId, $mediaType);
    }
}
