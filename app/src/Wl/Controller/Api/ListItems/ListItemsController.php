<?php

namespace Wl\Controller\Api\ListItems;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Api\Factory\ApiTransportFactory;
use Wl\Http\HttpService\IHttpService;
use Wl\Lists\ListItems\IListItem;
use Wl\Lists\ListItems\ListItemExporter;
use Wl\Lists\ListItems\ListItemsService\IListItemsService;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;
use Wl\Lists\ListItems\ListItemStatus\ListItemStatusValidator;
use Wl\Media\MediaCacheService\IMediaCacheService;
use Wl\Media\MediaLocale\MediaLocale;
use Wl\Mvc\Result\ApiResult;
use Wl\User\AuthService\IAuthService;
use Wl\Utils\Date\Date;

class ListItemsController
{
    /**
     * @Inject
     * @var IHttpService
     */
    private $httpService;

    /**
     * @Inject
     * @var IAuthService
     */
    private $authService;

    /**
     * @Inject
     * @var ApiTransportFactory
     */
    private $transportFactory;

    /**
     * @Inject
     * @var ApiAdapterFactory
     */
    private $adapterFactory;

    /**
     * @Inject
     * @var ListItemStatusValidator
     */
    private $statusValidator;

    /**
     * @Inject
     * @var IMediaCacheService
     */
    private $mediaCacheService;

    /**
     * @Inject
     * @var IListItemsService
     */
    private $listItemsService;

    public function put($urlParams)
    {
        if (!$this->authService->account()) {
            return ApiResult::errorAccessDenied();
        }

        $listId = $urlParams['listId'];

        // TODO check list permissions

        $params = $this->httpService->request()->post();

        $api = $params->get('api');
        $mediaId = $params->get('mediaId');
        $mediaType = $params->get('mediaType');
        $status = (int) $params->get('status');
        $date = $params->get('date');
        $locale = 'ru'; // TODO

        // do a very basic validation here, frontend should send correct data
        if (
            empty($api)
            || empty($mediaId)
            || empty($mediaType)
            || empty($listId)
            || empty($locale)
            || empty($status)
            || empty($date)
            || !$this->statusValidator->isValidStatus($status)
        ) {
            return ApiResult::error("invalid_request");
        }

        try {
            $parsedDate = Date::fromTimestamp($date);

            // get API transport
            $transport = $this->transportFactory->getTransport($api);

            // fetch api data container with api response
            $data = $transport->getMediaDetails($mediaId, $locale, $mediaType);

            // convert data container to media locale
            $mediaLocale = $this->adapterFactory->getAdapter($api)->buildMediaLocale(new MediaLocale(), $data);

            // upsert data container to media cache database
            $this->mediaCacheService->addToCache($api, $mediaId, $locale, $mediaLocale->getTitle(), $data);

            // add list item record
            $itemId = $this->listItemsService->addListItem(
                $listId,
                $mediaLocale->getMedia()->getApi(),
                $mediaLocale->getMedia()->getApiMediaId()
            );

            // add intial status
            $this->listItemsService->addListItemStatus(
                $itemId,
                $status,
                $this->authService->account()->getId(),
                $parsedDate->date()
            );

            return ApiResult::success();
        } catch (\Exception $e) {
            return ApiResult::errorInternal($e->getMessage());
        }
    }

    public function get($urlParams)
    {
        $params = $this->httpService->request()->get();
        
        $listId = $urlParams['listId'];
        $locale = 'ru'; // TODO
        $page = $params->get('page');

        if ((int) $page < 1) {
            $page = 1;
        }

        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $itemsResult = $this->listItemsService->getListItems($listId, $locale, $perPage, $offset);
        $items = [];
        foreach ($itemsResult->getItems() as $item) {
            $items[] = ListItemExporter::export($item);
        }

        return ApiResult::success([
            'total' => $itemsResult->getTotal(),
            'items' => $items
        ]);
    }
}
