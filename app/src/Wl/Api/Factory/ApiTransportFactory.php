<?php

namespace Wl\Api\Factory;

use Wl\Api\Client\Shikimori\ShikimoriTransport;
use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Api\Factory\Exception\InvalidApiIdException;
use Wl\Api\Transport\CachedTransport;
use Wl\Api\Transport\ITransport;
use Wl\Datasource\KeyValue\IStorage;

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

    /**
     * @Inject
     * @var IStorage
     */
    private $cache;

    public function getTransport($apiId): ITransport
    {
        switch ($apiId) {
            case TmdbTransport::API_ID:
                return $this->tmdb;
            case ShikimoriTransport::API_ID:
                return $this->shikimori;
        }

        throw new InvalidApiIdException("Invalid api id");
    }

    public function enableCache(ITransport $transport): ITransport
    {
        return new CachedTransport($this->cache, $transport);
    }
}
