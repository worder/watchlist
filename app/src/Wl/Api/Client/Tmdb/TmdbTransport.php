<?php

namespace Wl\Api\Client\Tmdb;

use Exception;
use Wl\Api\Client\Tmdb\Entity\TmdbConfigurationResponse;
use Wl\Api\DataAdapter\DataResolver;
use Wl\Media\ApiDataContainer\ApiDataContainer;
use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Api\Search\Exception\MediaTypeNotSupportedException;
use Wl\Api\Search\Exception\NotFoundException;
use Wl\Api\Search\Exception\RequestFailedException;
use Wl\Api\Search\Query\ISearchQuery;
use Wl\Api\Search\Result\ISearchResult;
use Wl\Api\Search\Result\SearchResult;
use Wl\Api\Transport\ITransport;
use Wl\Datasource\KeyValue\IStorage;
use Wl\Datasource\KeyValue\KeyDecoratedStorage;
use Wl\HttpClient\HttpRequestException;
use Wl\HttpClient\IHttpClient;
use Wl\HttpClient\Request\Request;
use Wl\Media\MediaType;
use Wl\Utils\Date\Date;

class TmdbTransport implements ITransport
{
    const API_ID = 'API_TMDB';

    const CONTAINER_META_PARAM_REQUEST_LOCALE  = 'request_locale';
    const CONTAINER_META_PARAM_MEDIA_TYPE = 'media_type';
    const CONTAINER_META_PARAM_CONFIG = 'config';

    const CACHE_KEY_CONFIGURATION = 'conf';

    const URL_BASE = 'https://api.themoviedb.org/3';

    private $apiKey;
    private $httpc;
    private $localCache;

    public function __construct(IHttpClient $httpc, TmdbTransportConfig $config, IStorage $cache)
    {
        $this->apiKey = $config->getApiKey();
        $this->httpc = $httpc;
        $this->httpc->setProxy($config->getProxy());
        $this->localCache = new KeyDecoratedStorage($cache, 'local_' . $this->getApiId());
    }

    public function getApiId()
    {
        return self::API_ID;
    }

    public function getSupportedMediaTypes(): array
    {
        return [
            MediaType::MOVIE,
            MediaType::TV_SERIES,
        ];
    }

    public function search(ISearchQuery $q): ISearchResult
    {
        if (empty($q->getTerm())) {
            throw new Exception('Term can not be empty');
        }

        $result = [];
        if ($q->getMediaType() === MediaType::MOVIE) {
            $result = $this->searchMovie($q);
        }

        if ($q->getMediaType() === MediaType::TV_SERIES) {
            $result = $this->searchTvSeries($q);
        }

        return $result;
    }

    public function getMediaDetails($mediaId, $locale, $mediaType = null): IApiDataContainer
    {
        if (empty($mediaId)) {
            throw new Exception('Media id can not be empty');
        }

        switch ($mediaType) {
            case MediaType::MOVIE:
                return $this->getMovieDetails($mediaId, $locale);
            case MediaType::TV_SERIES:
                return $this->getTvDetails($mediaId, $locale);
        }

        throw new MediaTypeNotSupportedException('Searching media type "' . ($mediaType ?: 'null') . '" is not supported');
    }

    public function getConfiguration()
    {
        $data = $this->localCache->get(self::CACHE_KEY_CONFIGURATION);
        if (empty($data)) {
            $data = $this->call('configuration');
            $this->localCache->set(self::CACHE_KEY_CONFIGURATION, $data, Date::now()->plusDays(7)->timestamp());
        }

        $conf = new DataResolver($data);
        $images = $conf->arr('images');
        $confObj = new TmdbConfigurationResponse();
        $confObj->baseUrl = $images->str('base_url');
        $confObj->secureBaseUrl = $images->str('base_url');
        $confObj->posterSizes = $images->getArray('poster_sizes');

        return $confObj;
    }

    private function getMovieDetails($mediaId, $locale = null): IApiDataContainer
    {
        $params = [
            "language" => $this->parseLocale($locale),
        ];
        $data = $this->call('movie/' . $mediaId, $params);
        return $this->createContainer($data, MediaType::MOVIE);
    }

    private function getTvDetails($mediaId, $locale = null): IApiDataContainer
    {
        $params = [
            "language" => $this->parseLocale($locale),
        ];
        $data = $this->call('tv/' . $mediaId, $params);
        return $this->createContainer($data, MediaType::TV_SERIES);
    }

    private function searchMovie(ISearchQuery $q): ISearchResult
    {
        $params = [
            "language" => $this->parseLocale($q->getLocale()),
            "page" => $q->getPage() ?? 1,
            "query" => $q->getTerm(),
        ];

        $response = $this->call('search/movie', $params);

        $result = new SearchResult();
        $result->setPage($q->getPage());
        $result->setPages($response['total_pages']);
        $result->setTotal($response['total_results']);
        foreach ($response['results'] as $data) {
            $result->addContainer($this->createContainer($data, MediaType::MOVIE));
        }
        return $result;
    }

    private function searchTvSeries(ISearchQuery $q): ISearchResult
    {
        $params = [
            "language" => $this->parseLocale($q->getLocale()),
            "page" => $q->getPage(),
            "query" => $q->getTerm(),
        ];

        $response = $this->call('search/tv', $params);

        $result = new SearchResult();
        $result->setPage($q->getPage());
        $result->setPages($response['total_pages']);
        $result->setTotal($response['total_results']);
        foreach ($response['results'] as $data) {
            $result->addContainer($this->createContainer($data, MediaType::TV_SERIES));
        }
        return $result;
    }

    private function call($method, $data = [])
    {
        $request = Request::get(self::URL_BASE . "/{$method}");
        $request->setParam('api_key', $this->apiKey);
        $request->addParams($data);

        try {
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
        } catch (HttpRequestException $e) {
            throw new RequestFailedException("Tmdb request failed: " . $e->getMessage());
        }

        return false;
    }

    private function parseLocale($locale)
    {
        return 'ru-RU'; // TODO
    }

    private function createContainer($data, $mediaType)
    {
        $container = new ApiDataContainer($data, self::API_ID);
        $container->setMetadataParam(self::CONTAINER_META_PARAM_MEDIA_TYPE, $mediaType);
        $container->setMetadataParam(self::CONTAINER_META_PARAM_REQUEST_LOCALE, 'ru');
        $container->setMetadataParam(self::CONTAINER_META_PARAM_CONFIG, (array) $this->getConfiguration());
        return $container;
    }
}
