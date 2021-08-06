<?php

namespace Wl\User\AccountService;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAccountService
{
    public function getAccountById($id): ?IAccount;
    public function getAccountByCredentials(ICredentials $credencials): ?IAccount;

    public function addAccount(IAccount $accountData);
    public function validateAccount(IAccount $account);
    
    public function addCredentials(ICredentials $credentials);
    public function validateCredentials(ICredentials $credentials);
}