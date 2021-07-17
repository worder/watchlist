<?php

namespace Wl\Api\Client\Tmdb;

use Wl\Api\Data\DataContainer\DataContainer;
use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Api\Search\Exception\MediaTypeNotSupportedException;
use Wl\Api\Search\Exception\NotFoundException;
use Wl\Api\Search\Exception\RequestFailedException;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchResult;
use Wl\Api\Search\Result\SearchResult;
use Wl\Api\Transport\ITransport;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\Request;
use Wl\Media\MediaLocalization;
use Wl\Media\MediaType;

class TmdbTransport implements ITransport
{
    const DATASOURCE_TYPE = 'API_TMDB';

    const URL_BASE = 'https://api.themoviedb.org/3';

    private $apiKey;
    private $httpc;

    public function __construct(IHttpClient $httpc, $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpc = $httpc;
    }

    public function getType()
    {
        return self::DATASOURCE_TYPE;
    }

    public function search(ISearchQuery $q): ISearchResult
    {
        $result = [];
        if ($q->getMediaType() === MediaType::MOVIE) {
            $result = $this->searchMovie($q);
        }

        if ($q->getMediaType() === MediaType::TV_SERIES) {
            $result = $this->searchTvSeries($q);
        }

        return $result;
    }

    public function getMediaDetails($mediaId, $mediaType = null): IDataContainer
    {
        switch ($mediaType) {
            case MediaType::MOVIE:
                return $this->getMovieDetails($mediaId);
            case MediaType::TV_SERIES:
                return $this->getTvDetails($mediaId);
        }

        throw new MediaTypeNotSupportedException('Searching media type "' . ($mediaType ?: 'null') . '" is not supported');
    }

    private function getMovieDetails($mediaId): IDataContainer
    {
        $params = [
            "language" => "ru-RU",
        ];
        $response = $this->call('movie/' . $mediaId, $params);
        return new DataContainer($response, self::DATASOURCE_TYPE);
    }

    private function getTvDetails($mediaId): IDataContainer
    {
        $params = [
            "language" => "ru-RU",
        ];
        $response = $this->call('tv/' . $mediaId, $params);
        return new DataContainer($response, self::DATASOURCE_TYPE);
    }

    private function searchMovie(ISearchQuery $q): ISearchResult
    {
        $params = [
            "language" => "ru-RU",
            "page" => $q->getPage(),
            "query" => $q->getTerm(),
        ];

        $response = $this->call('search/movie', $params);
        
        $result = new SearchResult();
        $result->setPage($q->getPage());
        $result->setPages($response['total_pages']);
        $result->setTotal($response['total_results']);
        foreach ($result['results'] as $data) {
            $result->addContainer(new DataContainer($data, self::DATASOURCE_TYPE));
        }
        return $result;
    }

    private function searchTvSeries(ISearchQuery $q): ISearchResult
    {
        $params = [
            "language" => "ru-RU",
            "page" => $q->getPage(),
            "query" => $q->getTerm(),
        ];

        $response = $this->call('search/tv', $params);
        
        $result = new SearchResult();
        $result->setPage($q->getPage());
        $result->setPages($response['total_pages']);
        $result->setTotal($response['total_results']);
        foreach ($response['results'] as $data) {
            $result->addContainer(new DataContainer($data, self::DATASOURCE_TYPE));
        }
        return $result;
    }

    private function call($method, $data = [])
    {
        $request = Request::get(self::URL_BASE . "/{$method}");
        $request->setParam('api_key', $this->apiKey);
        $request->addParams($data);

        $result = $this->httpc->dispatch($request);
        $code = $result->getHttpCode();

        if ($code === 200) {
            $json = $result->getBody();
            return json_decode($json, true);
        } elseif ($code === 400) {
            throw new NotFoundException();
        } else {
            throw new RequestFailedException("Tmdb request failed: code " . $code);
        }

        return false;
    }
}
