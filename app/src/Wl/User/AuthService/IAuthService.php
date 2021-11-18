<?php

namespace Wl\User\AuthService;

use Wl\User\Account\IAccount;
use Wl\User\AuthService\Exception\AuthException;
use Wl\User\Credentials\ICredentials;

interface IAuthService 
{
    /**
     * @throws AuthException
     */
    public function authenticate(ICredentials $credentials): IAccount;   
    
    public function account(): ?IAccount;

    public function login(IAccount $account);
    public function logout();
}