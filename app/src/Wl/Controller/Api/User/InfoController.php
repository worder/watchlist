<?php

namespace Wl\Controller\Api\User;

use Wl\Mvc\Result\ApiResult;
use Wl\Mvc\Result\JsonResult;
use Wl\User\AuthService\IAuthService;

class InfoController 
{
    /** 
     * @Inject
     * @var IAuthService 
     * */
    private $authService;

    public function get()
    {
        $account = $this->authService->account();

        $result = null;
        if ($account) {
            $result = [
                'id' => $account->getId(),
                'email' => $account->getEmail(),
                'username' => $account->getUsername(),
            ];

            return ApiResult::success($result);
        }

        return ApiResult::success(null);
    }
}