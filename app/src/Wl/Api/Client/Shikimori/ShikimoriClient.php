<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\Search\Query\ISearchQuery;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\IRequest;
use Wl\HttpClient\Request\Request;

class ShikimoriClient 
{
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

        if ($result->getHttpCode() === 200) {
            $data = json_decode($result->getBody(), true);
            return $data;
        }
    }


}