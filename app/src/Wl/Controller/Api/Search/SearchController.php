<?php

namespace Wl\Controller\Api\Search;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Api\Factory\ApiTransportFactory;
use Wl\Api\Factory\Exception\InvalidApiIdException;
use Wl\Api\Search\Query\SearchQuery;
use Wl\Http\HttpService\IHttpService;
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
            return ApiResult::error('INVALID_TERM');
        }

        try {
            $rawTransport = $this->apiTransportFactory->getTransport($clientId);
            $transport = $this->apiTransportFactory->enableCache($rawTransport);
            
            if (!in_array($mediaType, $transport->getSupportedMediaTypes())) {
                return ApiResult::error('UNSUPPORTED_MEDIA_TYPE');
            }

            $sq = new SearchQuery($term, $page, 10, $mediaType);
            
            try {
                $result = $transport->search($sq);

                $adapter = $this->apiAdapterFactory->getAdapter($clientId);
                
                $mediaList = [];
                foreach($result as $container) {
                    $mediaList[] = $adapter->getMedia($container);
                }

                var_dump($mediaList);

                // return ApiResult::success($result);
            } catch (\Exception $e) {
                return ApiResult::error('TRANSPORT_ERROR', $e->getMessage());
            }
        } catch (InvalidApiIdException $e) {
            return ApiResult::error('INVALID_API_ID');
        }
    }
}