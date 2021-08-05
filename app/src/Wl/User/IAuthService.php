<?php

namespace Wl\User;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAuthService 
{
    public function authenticate(ICredentials $credentials): bool;   
    public function getAccount(): ?IAccount;

    public function createDigestCredentials($login, $password): ICredentials;
}