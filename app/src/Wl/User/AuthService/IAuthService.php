<?php

namespace Wl\User\AuthService;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAuthService 
{
    public function authenticate(ICredentials $credentials): ?IAccount;   
    public function getAccount(): ?IAccount;
}