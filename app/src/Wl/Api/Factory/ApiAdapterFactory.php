<?php

namespace Wl\Api\Factory;

use Wl\Api\Client\Shikimori\ShikimoriAdapter;
use Wl\Api\Client\Shikimori\ShikimoriTransport;
use Wl\Api\Client\Tmdb\TmdbAdapter;
use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Api\Data\DataAdapter\IDataAdapter;
use Wl\Api\Factory\Exception\InvalidApiIdException;

class ApiAdapterFactory
{
    /**
     * @Inject
     * @var TmdbAdapter
     */
    private $tmdb;

    /**
     * @Inject
     * @var ShikimoriAdapter
     */
    private $shikimori;

    public function getAdapter($apiId): IDataAdapter
    {
        switch ($apiId) {
            case TmdbTransport::API_ID:
                return $this->tmdb;
            case ShikimoriTransport::API_ID:
                return $this->shikimori;
        }

        throw new InvalidApiIdException($apiId);
    }
}
