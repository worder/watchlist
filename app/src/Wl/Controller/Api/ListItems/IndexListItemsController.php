<?php

namespace Wl\Controller\Api\ListItems;

use Wl\Lists\ListItems\ListItemExporter;
use Wl\Lists\ListItems\ListItemsService\IListItemsService;
use Wl\Mvc\Result\ApiResult;
use Wl\User\AuthService\IAuthService;

class IndexListItemsController 
{
    /**
     * @Inject
     * @var IAuthService
     */
    private $authService;

    /**
     * @Inject
     * @var IListItemsService
     */
    private $listItemsService;


    public function get($params)
    {
        if (!$this->authService->account()) {
            return ApiResult::errorAccessDenied();
        }

        $locale = 'ru'; //TODO
        $page = (int) $params['page'];
        if ($page < 1) {
            $page = 1;
        }

        $onPage = 20;
        $offset = ($page - 1) * $onPage;

        $userId = $this->authService->account()->getId();
        $items = $this->listItemsService->getUserMainPageItems($userId, $locale, $offset, $onPage);

        $total = $items->getTotal();
        $pages = ceil($total / $onPage);

        $out = [
            'total' => $total,
            'pages' => $pages,
            'page' => $page,
            'items' => [],
        ];
        foreach ($items->getItems() as $item) {
            $out['items'][] = ListItemExporter::export($item);
        }

        return ApiResult::success($out);
    }
}