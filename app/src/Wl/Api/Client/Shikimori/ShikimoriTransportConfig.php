<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\Transport\ATransportConfig;
use Wl\Api\Transport\ITransportConfig;

class ShikimoriTransportConfig extends ATransportConfig implements ITransportConfig
{
    protected function getApiConfig()
    {
        $conf = $this->config->get('API_SETTINGS');
        return $conf['API_SHIKIMORI'] ?? [];
    }

    public function getAppName()
    {
        return $this->getApiConfigParam('APP_NAME');
    }
}