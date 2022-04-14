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
            $out[] = array_merge(
                [
                    'api_id' => $t->getApiId(),
                    'media_types' => $t->getSupportedMediaTypes()
                ],
                $this->getApiDescriptionById($t->getApiId())
            );
        }

        return new JsonResult($out);
    }

    private function getApiDescriptionById($id)
    {
        switch ($id) {
            case TmdbTransport::API_ID:
                return [
                    'name_short' => 'TMDB',
                    'name' => 'The Movie Database (TMDB)'
                ];
            case ShikimoriTransport::API_ID:
                return [
                    'name_short' => 'Shikimori',
                    'name' => 'shikimori.one'
                ];
        }
    }
}
