<?php

namespace Wl\Api\Client\Shikimori;

class ShikimoriTransportConfig
{
    private $appName;

    public function __construct($oauthAppName/*, $oauthClientId, $oauthClientSecret*/)
    {
        $this->appName = $oauthAppName;
    }

    public function getAppName()
    {
        return $this->appName;
    }

    // public function getClientId()
    // {

    // }

    // public function getClientSecret()
    // {

    // }
}