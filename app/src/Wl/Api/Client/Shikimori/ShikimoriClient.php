<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\SearchCollection;
use Wl\Api\Search\Result\SearchItem;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\IRequest;
use Wl\HttpClient\Request\Request;
use Wl\Media\MediaLocalization;
use Wl\Media\MediaType;

class ShikimoriClient 
{
    const DATASOURCE_NAME = 'API_SHIKIMORI';

    private $transport;
    private $config;

    private $apiUrl = 'https://shikimori.one/api/';

    public function __construct(IHttpClient $httpc, ShikimoriClientConfig $config)
    {
        $this->transport = $httpc;
        $this->config = $config;
    }

    public function search(ISearchQuery $q)
    {
        $request = Request::get($this->apiUrl . 'animes');
        $request->setParams([
            'limit' => 10,
            'search' => $q->getTerm(),
            'page' => $q->getPage(),
        ]);
        $request->setHeader("User-Agent", $this->config->getAppName());

        $result = $this->transport->dispatch($request);

        $data = [];
        if ($result->getHttpCode() === 200) {
            $data = json_decode($result->getBody(), true);
        }

        return $this->buildResult($data, $q);
    }

    private function buildResult($items, ISearchQuery $q)
    {
        $col = new SearchCollection();
        $col->setPage($q->getPage());

        foreach ($items as $data) {
            $item = new SearchItem();
            $item->setDatasourceName(self::DATASOURCE_NAME);
            $item->setDatasourceSnapshot($data);
            $item->setMediaType(MediaType::ANIME_SERIES);
            
            $item->setOriginalLocalization(new MediaLocalization('en', $data['name']));
            $item->addLocalization(new MediaLocalization('ru', $data['russian']));

            $item->setId($data['id']);
            $item->setReleaseDate($data['aired_on']);

            $col->addItem($item);
        }

        return $col;
    }


}