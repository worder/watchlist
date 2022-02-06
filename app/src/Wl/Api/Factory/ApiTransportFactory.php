<?php

namespace Wl\Api\Factory;

use Wl\Api\Client\Shikimori\ShikimoriTransport;
use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Api\Transport\ITransport;

class ApiTransportFactory
{
    /**
     * @Inject
     * @var TmdbTransport
     */
    private $tmdb;

    /**
     * @Inject
     * @var ShikimoriTransport
     */
    private $shikimori;

    public function getTransport($apiId): ITransport
    {
        switch ($apiId) {
            case TmdbTransport::API_ID:
                return $this->tmdb;
            case ShikimoriTransport::API_ID:
                return $this->shikimori;
        }
    }
}
