<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Media\DataContainer\DataContainer;
use Wl\Media\DataContainer\IDataContainer;
use Wl\Api\Search\Exception\MediaTypeNotSupportedException;
use Wl\Api\Search\Exception\NotFoundException;
use Wl\Api\Search\Exception\RequestFailedException;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchResult;
use Wl\Api\Search\Result\SearchResult;
use Wl\Api\Transport\ITransport;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\Request;

use Wl\Media\MediaType;

class ShikimoriTransport implements ITransport
{
    const API_ID = 'API_SHIKIMORI';

    private $transport;
    private $config;

    private $apiUrl = 'https://shikimori.one/api/';

    const MEDIA_TYPE_TV = 'tv';
    const MEDIA_TYPE_MOVIE = 'movie';
    const MEDIA_TYPE_OVA = 'ova';
    const MEDIA_TYPE_ONA = 'ona';
    const MEDIA_TYPE_SPECIAL = 'special';

    const MEDIA_TYPES_DICT = [
        MediaType::ANIME_SERIES => self::MEDIA_TYPE_TV,
        MediaType::ANIME_MOVIE => self::MEDIA_TYPE_MOVIE,
        MediaType::ANIME_ONA => self::MEDIA_TYPE_ONA,
        MediaType::ANIME_OVA => self::MEDIA_TYPE_OVA,
        MediaType::ANIME_SPECIAL => self::MEDIA_TYPE_SPECIAL,
    ];

    
    public function __construct(IHttpClient $httpc, ShikimoriTransportConfig $config)
    {
        $this->transport = $httpc;
        $this->config = $config;
    }
    
    public function getApiId()
    {
        return self::API_ID;
    }

    public function getSupportedMediaTypes(): array
    {
        return array_keys(self::MEDIA_TYPES_DICT);
    }

    public function search(ISearchQuery $q): ISearchResult
    {
        $request = Request::get($this->apiUrl . 'animes');
        $request->setHeader("User-Agent", $this->config->getAppName());
        $request->setParams([
            'limit' => 8,
            'search' => $q->getTerm(),
            'page' => $q->getPage(),
        ]);

        $mediaType = $q->getMediaType();
        if ($mediaType !== null && !isset(self::MEDIA_TYPES_DICT[$mediaType])) {
            throw new MediaTypeNotSupportedException('Media type "' . $mediaType . '" is not supported in this client');
        }
        if ($mediaType) {
            $request->setParam('kind', self::MEDIA_TYPES_DICT[$mediaType]);
        }

        $result = $this->transport->dispatch($request);

        $data = [];
        if ($result->getHttpCode() === 200) {
            $data = json_decode($result->getBody(), true);
        } else {
            throw new RequestFailedException('API request failed: code ' . $result->getHttpCode());
        }

        $items = [];
        foreach ($data as $itemData) {
            $items[] = new DataContainer($itemData, self::API_ID);
        }

        $result = new SearchResult($items);
        $result->setPage($q->getPage());
        $result->setPages(0); // no pages info available

        return $result;
    }

    public function getMediaDetails($mediaId, $mediaType = null): IDataContainer
    {
        $request = Request::get($this->apiUrl . 'animes/' . $mediaId);
        $request->setHeader("User-Agent", $this->config->getAppName());

        if ($mediaType && isset(self::MEDIA_TYPES_DICT[$mediaType])) {
            $request->setParam('kind', self::MEDIA_TYPES_DICT[$mediaType]);
        }

        $result = $this->transport->dispatch($request);
        if ($result->getHttpCode() === 200) {
            $data = json_decode($result->getBody(), true);
            return new DataContainer($data, self::API_ID);
        } elseif ($result->getHttpCode() === 400) {
            throw new NotFoundException();
        } else {
            throw new RequestFailedException('API request failed: code ' . $result->getHttpCode());
        }
    }
}
