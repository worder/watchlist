<?php

namespace Wl\Api\Cache;

use Wl\Api\Search\ISearchClient;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchCollection;
use Wl\Api\Search\Result\ISearchItem;
use Wl\Api\Search\Result\SearchItemDataContainer;
use Wl\Datasource\KeyValue\IStorage;
use Wl\Datasource\KeyValue\KeyDecoratedStorage;

class CachedClient implements ISearchClient
{
    private $backend;
    private $storage;

    public function getDatasourceName()
    {
        return $this->backend->getDatasourceName();
    }

    public function __construct(IStorage $storage, ISearchClient $backend)
    {
        $this->backend = $backend;
        $this->storage = new KeyDecoratedStorage($storage, $backend->getDatasourceName());
    }

    public function search(ISearchQuery $q): ISearchCollection
    {
        $qHash = $q->getTerm() . ':' . $q->getPage() . ':' . $q->getLimit() . ':' . $q->getMediaType();

        $data = $this->storage->get($qHash);
        if ($data) {
            $items = [];
            [$snaps, $expire] = $data;
            foreach ($snaps as $itemSnapshot) {
                $item = $this->backend->createItem(new SearchItemDataContainer($itemSnapshot, true, $expire));
                $items[] = $item;
            }
            return $this->backend->createCollection($items, $q);
        } else {
            $col = $this->backend->search($q);
            $expire = 60 * 60 * 24;
            $cache = [[], \time() + $expire];
            foreach ($col as $item) {
                $cache[0][] = $item->getDatasourceSnapshot();
            }
            $this->storage->add($qHash, $cache, $expire);

            return $col;
        }
    }

    public function createCollection(array $items, ISearchQuery $q): ISearchCollection
    {
        return $this->backend->createCollection($items, $q);
    }

    public function createItem($rawData): ISearchItem
    {
        return $this->backend->createItem($rawData);
    }

    public function getMediaDetails($mediaId, $mediaType): ISearchItem
    {
        return $this->backend->getMediaDetails($mediaId, $mediaType);
    }
}