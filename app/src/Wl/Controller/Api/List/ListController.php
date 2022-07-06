<?php

namespace Wl\Controller\Api\List;

use Wl\Http\HttpService\IHttpService;
use Wl\List\ListSubscriptionService\IListSubscriptionService;
use Wl\Lists\ListEntity;
use Wl\Lists\ListService\IListService;
use Wl\Lists\ListService\ListService;
use Wl\Lists\ListValidator\ListValidator;
use Wl\Lists\ListValidator\ListValidatorException;
use Wl\Lists\Subscription\ListSubscription;
use Wl\Lists\Subscription\ListSubscriptionService\ListSubscriptionService;
use Wl\Mvc\Result\ApiResult;
use Wl\Permissions\CrudPermission;
use Wl\Permissions\PermissionsList;
use Wl\User\AuthService\IAuthService;

class ListController
{
    const PUT_ERROR_VALIDATION = 'validation_error';
    const PUT_ERROR_INTERNAL = 'internal_error';

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

        if (!$this->authService->account()) {
            return ApiResult::accessDenied();
        }

        $data = $this->http->request()->post();

        $title = $data->get('title');
        $desc = $data->get('desc');

        $list = new ListEntity();
        $list->setTitle($title);
        $list->setDesc($desc);

        try {
            $validator = new ListValidator();
            $validator->validateListAdd($list);

            $addedList = $this->listService->createList($list);

            $perms = new PermissionsList();
            $perms->addPermission(CrudPermission::update());
            $perms->addPermission(CrudPermission::delete());

            $listOwnerSub = new ListSubscription();
            $listOwnerSub->setListId($addedList->getId());
            $listOwnerSub->setUserId($this->authService->account()->getId());
            $listOwnerSub->setPermissions($perms);

            $this->listSubscriptionService->createSubscription();
        } catch (ListValidatorException $e) {
            return ApiResult::error(self::PUT_ERROR_VALIDATION, $e->getMessage());
        } catch (\Exception $e) {
            return ApiResult::error(self::PUT_ERROR_INTERNAL, $e->getMessage());
        }

        echo 'media controller';
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
