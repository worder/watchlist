<?php

namespace Wl\Api\Transport;

use Wl\Config\IConfig;
use Wl\HttpClient\Proxy;

abstract class ATransportConfig implements ITransportConfig
{
    protected $config;

    public function __construct(IConfig $config)
    {
        $this->config = $config;
    }

    abstract protected function getApiConfig();
    
    protected function getApiConfigParam($key, $default = null)
    {
        $config = $this->getApiConfig();
        if (isset($config[$key])) {
            return $config[$key];
        }

        return $default;
    }

    public function getProxy(): Proxy
    {
        $proxy = $this->getApiConfigParam('PROXY');
        if (!empty($proxy)) {
            return new Proxy($proxy['type'], $proxy['proxy']);
        }
        
        return null;
    }

    public function getAssetProxyAllowedHosts(): array
    {
        $proxy = $this->getApiConfigParam('PROXY');
        return $proxy['asset_proxy_allowed_hosts'];
    }
}