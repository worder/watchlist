<?php

namespace Wl\Controller\Api\ListEntry;

use Wl\Lists\Subscription\ListSubscriptionService\IListSubscriptionService;
use Wl\Lists\ListService\IListService;
use Wl\Mvc\Result\ApiResult;

class UserListsController
{
    private $lss;

    public function __construct(IListSubscriptionService $lss)
    {
        $this->lss = $lss;
    }

    public function get($props)
    {
        if (!empty($props['userId'])) {
            $result = $this->lss->getUserSubscriptions((int) $props['userId']);
        } else {
            return ApiResult::error('empty_user_id');
        }        

        $response = [];
        foreach ($result as $sub) {
            $response[] = [
                'listId' => $sub->getListId(),
                'userId' => $sub->getUserId(),
                'title' => $sub->getList()->getTitle(),
                'desc' => $sub->getList()->getDesc(),
            ];
        }

        return ApiResult::success($response);
    }
}