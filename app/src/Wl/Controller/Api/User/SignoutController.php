<?php

namespace Wl\Controller\Api\User;

use Wl\Mvc\Result\ApiResult;
use Wl\User\AuthService\AuthService;

class SignoutController
{
    /**
     * @Inject
     * @var AuthService
     */
    private $authService;

    public function get()
    {
        $this->authService->logout();
        return ApiResult::success();
    }
}
