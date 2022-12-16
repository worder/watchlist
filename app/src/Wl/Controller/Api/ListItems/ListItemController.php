<?php

namespace Wl\Controller\Api\ListItems;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Api\Factory\ApiTransportFactory;
use Wl\Http\HttpService\IHttpService;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;
use Wl\Lists\ListItems\ListItemStatus\ListItemStatusValidator;
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

    public function put()
    {
        if (!$this->authService->account()) {
            return ApiResult::errorAccessDenied();
        }

        $params = $this->httpService->request()->post();

        $api = $params->get('api');
        $mediaId = $params->get('mediaId');
        $mediaType = $params->get('mediaType');
        $listId = (int) $params->get('listId');
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
            $transport = $this->transportFactory->getTransport($api);
            $data = $transport->getMediaDetails($mediaId, $locale, $mediaType);
            $mediaLocale = $this->adapterFactory->getAdapter($api)->buildMediaLocale(new MediaLocale(), $data);

            $this->mediaCacheService->addToCache($api, $mediaId, $locale, $mediaLocale->getTitle(), $data->getData());

            $this->listItemsService->addListItem(
                $listId,
                $mediaLocale->getMedia()->getApi(),
                $mediaLocale->getMedia()->getApiMediaId(),
                IListItemStatus::STATUS_PLANNED,
                Date::now()->date(),
                $this->authService->account()->getId()
            );
        } catch (\Exception $e) {
            return ApiResult::errorInternal($e->getMessage());
        }
    }
}
