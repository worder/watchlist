<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\Search\ISearchClient;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchCollection;
use Wl\Api\Search\Result\ISearchItem;
use Wl\Api\Search\Result\ISearchItemDataContainer;
use Wl\Api\Search\Result\SearchCollection;
use Wl\Api\Search\Result\SearchItem;
use Wl\Api\Search\Result\SearchItemDataContainer;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\Request;
use Wl\Media\MediaLocalization;
use Wl\Media\MediaType;

class ShikimoriClient implements ISearchClient
{
    const DATASOURCE_NAME = 'API_SHIKIMORI';

    private $transport;
    private $config;

    private $apiUrl = 'https://shikimori.one/api/';

    public function getDatasourceName()
    {
        return self::DATASOURCE_NAME;
    }

    public function __construct(IHttpClient $httpc, ShikimoriClientConfig $config)
    {
        $this->transport = $httpc;
        $this->config = $config;
    }

    public function search(ISearchQuery $q): ISearchCollection
    {
        $request = Request::get($this->apiUrl . 'animes');
        $request->setParams([
            'limit' => 8,
            'search' => $q->getTerm(),
            'page' => $q->getPage(),
        ]);
        $request->setHeader("User-Agent", $this->config->getAppName());

        $result = $this->transport->dispatch($request);

        $data = [];
        if ($result->getHttpCode() === 200) {
            $data = json_decode($result->getBody(), true);
        }

        $items = [];
        foreach ($data as $itemData) {
            $items[] = $this->createItem(new SearchItemDataContainer($itemData));
        }
        return $this->createCollection($items, $q);
    }

    public function getMediaDetails($mediaId, $mediaType): ISearchItem
    {
        $request = Request::get($this->apiUrl . 'animes/' . $mediaId);
        $request->setHeader("User-Agent", $this->config->getAppName());
        
        $result = $this->transport->dispatch($request);
        if ($result->getHttpCode() === 200) {
            $data = json_decode($result->getBody(), true);
            var_dump($data);
            die();
        } else {
            var_dump($result->getHttpCode());
            var_dump($result->getBody());
            var_dump($result->getRequestHeaders());
            var_dump($request->getUrl());
        }

        return new SearchItem(new SearchItemDataContainer([]));
    }

    public function createItem(ISearchItemDataContainer $dataCon): ISearchItem
    {
        $rawData = $dataCon->getDatasourceSnapshot();

        $item = new SearchItem($dataCon);
        $item->setDatasourceName(self::DATASOURCE_NAME);
        $item->setDatasourceSnapshot($rawData);
        $item->setMediaType(MediaType::ANIME_SERIES);

        $item->setOriginalLocalization(new MediaLocalization('en', $rawData['name']));
        $item->addLocalization(new MediaLocalization('ru', $rawData['russian']));

        $item->setMediaId($rawData['id']);
        $item->setReleaseDate($rawData['aired_on']);

        return $item;
    }

    public function createCollection(array $items, ISearchQuery $q): ISearchCollection
    {
        $col = new SearchCollection();
        $col->setPage($q->getPage());
        $col->setItems($items);

        return $col;
    }
}
