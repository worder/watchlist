<?php

namespace Wl\Controller\Api\Asset;

use Wl\Api\Factory\ApiTransportConfigFactory;
use Wl\Http\HttpService\HttpService;
use Wl\HttpClient\HttpClient;
use Wl\HttpClient\Request\Request;
use Wl\Mvc\Result\ApiResult;

class ProxyController
{
    /**
     * @Inject
     * @var ApiTransportConfigFactory
     */
    private $transportConfigFactory;

    /**
     * @Inject
     * @var HttpService
     */
    private $httpService;

    /**
     * @Inject
     * @var HttpClient
     */
    private $httpClient;

    public function get($params)
    {
        if (!isset($params['data'])) {
            return ApiResult::error('bad request');
        }
        $json = base64_decode($params['data']);
        $parts = json_decode($json);

        if (is_array($parts) && count($parts) === 2) {
            [$url, $apiId] = $parts;

            try {
                $tconf = $this->transportConfigFactory->getTransportConfig($apiId);
                $proxy = $tconf->getProxy();

                if (!$proxy) {
                    $this->httpService->redirect($url);
                }

                $whitelist = $tconf->getAssetProxyAllowedHosts();
                $allow = false;
                if (!$whitelist) {
                    return ApiResult::errorInternal('invalid_configuration');
                }
                foreach ($whitelist as $host) {
                    $qHost = preg_quote($host);
                    if (preg_match("/^https?:\/\/${qHost}/", $url)) {
                        $allow = true;
                        break;
                    }
                }
                if (!$allow) {
                    return ApiResult::errorAccessDenied();
                }

                try {
                    $this->httpClient->setProxy($proxy);
                    $result = $this->httpClient->dispatch(Request::get($url));

                    $h = $result->getHeaders();
                    if (isset($h['Content-Type'])) {
                        $this->httpService->header('Content-Type', $h['Content-Type']);
                    }

                    echo $result->getBody();
                    exit();
                } catch (\Exception $e) {
                    return ApiResult::errorInternal($e->getMessage());
                }
            } catch (\Exception $e) {
                return ApiResult::errorInternal($e->getMessage());
            }
        }

        return ApiResult::error();
    }
}