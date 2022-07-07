<?php

namespace Wl\Controller\Api\Search;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Api\Factory\ApiTransportFactory;
use Wl\Api\Factory\Exception\InvalidApiIdException;
use Wl\Api\Search\Query\SearchQuery;
use Wl\Http\HttpService\IHttpService;
use Wl\Media\Assets\Poster\IPoster;
use Wl\Media\MediaLocale\MediaLocale;
use Wl\Mvc\Result\ApiResult;

class SearchController
{

    /**
     * @Inject
     * @var IHttpService
     */
    private $http;


    /**
     * @Inject
     * @var ApiTransportFactory
     */
    private $apiTransportFactory;

    /**
     * @Inject
     * @var ApiAdapterFactory
     */
    private $apiAdapterFactory;

    // /api/search/?api=API_SHIKIMORI&type=anime_series&term=monogatari
    // /api/search/?api=API_TMDB&type=movie&term=avatar

    public function get($vars)
    {
        $params = $this->http->request()->get();

        $clientId = $params->get('api');
        $mediaType = $params->get('type');
        $term = $params->get('term');
        $page = $params->get('page');

        if (empty($term) && strlen($term) > 512) {
            return ApiResult::error('invalid_term');
        }

        try {
            $rawTransport = $this->apiTransportFactory->getTransport($clientId);
            $transport = $this->apiTransportFactory->enableCache($rawTransport);

            if (!in_array($mediaType, $transport->getSupportedMediaTypes())) {
                return ApiResult::error('unsupported_media_type');
            }

            $sq = new SearchQuery($term, $mediaType, $page);

            try {
                $result = $transport->search($sq);

                $adapter = $this->apiAdapterFactory->getAdapter($clientId);

                $items = [];
                foreach ($result as $container) {
                    $locale = $adapter->buildMediaLocale(new MediaLocale(), $container);
                    $media = $locale->getMedia();
                    $assets = $locale->getAssets();
                    $posterSizes = [IPoster::SIZE_SMALL, IPoster::SIZE_MEDIUM];
                    $posters = [];
                    if ($assets) {
                        foreach ($posterSizes as $size) {
                            $poster = $assets->getPoster($size);
                            if ($poster) {
                                $posters[$size] = $poster->getUrl();
                            }
                        }
                    }

                    $items[] = [
                        'id' => $media->getApiMediaId(),
                        'type' => $media->getMediaType(),
                        'title' => $locale->getTitle(),
                        'title_original' => $media->getOriginalTitle(),
                        'release_date' => $media->getReleaseDate(),
                        'posters' => $posters,
                    ];
                }

                $response = [
                    'total' => $result->getTotal(),
                    'page' => $result->getPage(),
                    'pages' => $result->getPages(),
                    'items' => $items,
                ];

                return ApiResult::success($response);
            } catch (\Exception $e) {
                return ApiResult::error('transport_error', $e->getMessage());
            }
        } catch (InvalidApiIdException $e) {
            return ApiResult::error('invalid_api_id');
        }
    }
}
