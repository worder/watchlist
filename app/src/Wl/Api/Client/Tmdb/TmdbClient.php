<?php

namespace Wl\Api\Client\Tmdb;

use Wl\Api\Search\Query\ISearchQuery;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\Request;
use Wl\Media\MediaType;

class TmdbClient
{
    const DATASOURCE_NAME = 'API_TMDB';

    const URL_BASE = 'https://api.themoviedb.org/3';

    private $apiKey;
    private $httpc;

    public function __construct(IHttpClient $httpc, $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpc = $httpc;
    }

    public function search(ISearchQuery $q)
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

    public function getMediaDetails($mediaId, $mediaType)
    {
        switch ($mediaType) {
            case MediaType::MOVIE:
                return $this->getMovieDetails($mediaId);
            case MediaType::TV_SERIES:
                return $this->getTvDetails($mediaId);
        }
    }

    public function getMovieDetails($mediaId)
    {
        $params = [
            "language" => "ru-RU",
        ];
        $response = $this->call('movie/' . $mediaId, $params);
        return $response;
    }

    public function getTvDetails($mediaId)
    {
        $params = [
            "language" => "ru-RU",
        ];
        $response = $this->call('tv/' . $mediaId, $params);
        var_dump($response);
        return $response;
    }

    private function searchMovie(ISearchQuery $q)
    {
        $params = [
            "language" => "ru-RU",
            "page" => 1,
            // "include_adult" => "true",
            "query" => $q->getTerm(),
        ];

        $result = $this->call('search/movie', $params);
        return $result;
    }

    private function searchTvSeries(ISearchQuery $q)
    {
        $params = [
            "language" => "ru-RU",
            "page" => $q->getPage(),
            // "include_adult" => "true",
            "query" => $q->getTerm(),
        ];

        $result = $this->call('search/tv', $params);
        return $result;
    }

    private function call($method, $data = [])
    {
        $params = ["api_key" => $this->apiKey];
        $reqData = http_build_query(array_merge($params, $data));

        $request = Request::get(self::URL_BASE . "/{$method}?{$reqData}");

        $result = $this->httpc->dispatch($request);

        if ($result->getHttpCode() == 200) {
            $json = $result->getBody();
            return json_decode($json, true);
        }

        return false;
    }
}
