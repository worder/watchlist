<?php

namespace Wl\Controller\Api\Consts;

use Wl\Api\Client\Shikimori\ShikimoriTransport;
use Wl\Api\Client\Tmdb\TmdbTransport;
use Wl\Api\Factory\ApiTransportFactory;
use Wl\Lists\ListItems\ListItemStatus\ListItemStatus;
use Wl\Mvc\Result\JsonResult;

class ConstsController
{
    /**
     * @Inject
     * @var ApiTransportFactory
     */
    private $tfactory;

    public function get()
    {
        $out = [];

        // out.statuses
        $out['list_item_statuses'] = [];
        foreach (ListItemStatus::$statusMnemonics as $id => $name) {
            $out['list_item_statuses'][] = [$id, $name];
        }

        $transports = [
            $this->tfactory->getTransport(TmdbTransport::API_ID),
            $this->tfactory->getTransport(ShikimoriTransport::API_ID)
        ];

        // out.apis
        foreach ($transports as $t) {
            $mediaTypes = $t->getSupportedMediaTypes();
            $id = $t->getApiId();

            $mediaTypesDict = [];
            foreach ($mediaTypes as $type) {
                $mediaTypesDict[] = ["id" => $type, "name" => $type];
            }

            switch ($id) {
                case TmdbTransport::API_ID:
                    $desc = [
                        'name_short' => 'TMDB',
                        'name' => 'The Movie Database (TMDB)'
                    ];
                case ShikimoriTransport::API_ID:
                    $desc = [
                        'name_short' => 'Shikimori',
                        'name' => 'shikimori.one'
                    ];
                default:
                    $desc = [
                        'name_short' => $id,
                        'name' => $id,
                    ];
            }

            $out['apis'][] = array_merge(
                [
                    'id' => $t->getApiId(),
                    'media_types' => $mediaTypesDict
                ],
                $desc
            );
        }

        return new JsonResult($out);
    }
}
