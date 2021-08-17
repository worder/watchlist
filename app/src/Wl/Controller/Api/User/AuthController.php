<?php

namespace Wl\Controller\Api\User;

use Wl\User\AuthService\IAuthService;

class AuthController 
{
    /**
     * @Inject
     * @var IAuthService
     */
    private $authService;

    public function get($vars)
    {
        var_dump('yatta!');
    }
}