<?php

namespace Wl\User;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAuthService 
{
    public function authenticate(ICredentials $credentials): bool;   
    public function getUserAccount(): ?IAccount;
}