<?php

namespace Wl\User;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAccountService
{
    public function getAccountById($id): ?IAccount;
    public function getAccountByCredentials(ICredentials $credencials): ?IAccount;

    public function addAccount(IAccount $accountData, ICredentials $credentials);
    public function addCredentials(ICredentials $credentials);
}