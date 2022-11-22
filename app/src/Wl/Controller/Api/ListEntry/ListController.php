<?php

namespace Wl\Controller\Api\ListEntry;

use Wl\Http\HttpService\IHttpService;
use Wl\Lists\Subscription\ListSubscriptionService\IListSubscriptionService;
use Wl\Lists\ListEntity;
use Wl\Lists\ListService\IListService;
use Wl\Lists\ListValidator\ListValidator;
use Wl\Lists\ListValidator\ListValidatorException;
use Wl\Lists\Subscription\ListSubscription;
use Wl\Mvc\Result\ApiResult;
use Wl\User\AuthService\IAuthService;

class ListController
{
    const PUT_ERROR_VALIDATION = 'validation_error';
    const PUT_ERROR_INTERNAL = 'internal_error';
    const PUT_SUCCESS = 'put_success';

    private $http;
    private $listService;
    private $listSubscriptionService;
    private $authService;

    public function __construct(
        IHttpService $http,
        IListService $listService,
        IListSubscriptionService $listSubsService,
        IAuthService $authService
    ) {
        $this->http = $http;
        $this->listService = $listService;
        $this->listSubscriptionService = $listSubsService;
        $this->authService = $authService;
    }

    public function put()
    {
        // 1. create list
        // 2. subscribe user to list with owner privileges

        $user = $this->authService->account();

        if (!$user) {
            return ApiResult::errorAccessDenied();
        }

        $data = $this->http->request()->post();

        $title = (string) $data->get('title');
        $desc = (string) $data->get('desc');

        $list = new ListEntity();
        $list->setTitle($title);
        $list->setDesc($desc);
        $list->setOwnerId($user->getId());

        try {
            $validator = new ListValidator();
            $validator->validateListAdd($list);

            $addedList = $this->listService->createList($list);

            $listOwnerSub = new ListSubscription();
            $listOwnerSub->setListId($addedList->getId());
            $listOwnerSub->setUserId($this->authService->account()->getId());

            $this->listSubscriptionService->createSubscription($listOwnerSub);
            return ApiResult::success();
        } catch (ListValidatorException $e) {
            return ApiResult::error('validation_error', $e->getMessage());
        } catch (\Exception $e) {
            return ApiResult::errorInternal($e->getMessage());
        }
    }

    public function patch()
    {
        // TODO edit list
    }



    public function delete($id)
    {
        // TODO delete list;
    }
}
