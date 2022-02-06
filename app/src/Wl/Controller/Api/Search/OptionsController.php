<?php

namespace Wl\Controller\Api\Search;

use Wl\Api\Client\Shikimori\ShikimoriTransport;
use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Api\Factory\ApiTransportFactory;
use Wl\Mvc\Result\JsonResult;

class OptionsController
{
    /**
     * @Inject
     * @var ApiTransportFactory
     */
    private $tfactory;

    public function get()
    {
        $transports = [
            $this->tfactory->getTransport(TmdbTransport::API_ID),
            $this->tfactory->getTransport(ShikimoriTransport::API_ID)
        ];
        
        $out = [];
        foreach ($transports as $t) {
            $out[$t->getApiId()] = $t->getSupportedMediaTypes();
        }

        return new JsonResult($out);
    }
}