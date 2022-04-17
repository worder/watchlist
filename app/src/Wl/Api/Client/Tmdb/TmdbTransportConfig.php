<?php

namespace Wl\Api\Client\Tmdb;

use Wl\Api\Transport\ATransportConfig;
use Wl\Api\Transport\ITransportConfig;
use Wl\HttpClient\Proxy;

class TmdbTransportConfig extends ATransportConfig implements ITransportConfig
{
    protected function getApiConfig()
    {
        $conf = $this->config->get('API_SETTINGS');
        return $conf['API_TMDB'] ?? [];
    }

    public function getApiKey()
    {
        return $this->getApiConfigParam('API_KEY');
    }
}
