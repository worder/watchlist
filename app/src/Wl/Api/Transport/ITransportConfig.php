<?php

namespace Wl\Api\Transport;

use Wl\HttpClient\Proxy;

interface ITransportConfig 
{
    public function getProxy(): Proxy;
    public function getAssetProxyAllowedHosts(): array;
}