<?php

namespace Wl\Api\Factory;

use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Api\Client\Tmdb\TmdbTransportConfig;
use Wl\Api\Factory\Exception\InvalidApiIdException;

class ApiTransportConfigFactory
{
    /**
     * @Inject
     * @var TmdbTransportConfig
     */
    private $tmdbConfig;

    public function getTransportConfig($apiId)
    {
        switch ($apiId) {
            case TmdbTransport::API_ID:
                return $this->tmdbConfig;
        }

        throw new InvalidApiIdException("Failed to locate config for api: \"{$apiId}\"");
    }
}