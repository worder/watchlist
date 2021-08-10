<?php

namespace Wl\User\AccountService;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAccountService
{
    public function getAccountById($id): ?IAccount;
    public function getAccountByEmail($email): ?IAccount;
    public function getAccountByUsername($username): ?IAccount;
    public function getAccountByCredentials(ICredentials $credencials): ?IAccount;

    public function addAccount(IAccount $accountData);
    public function addCredentials($accountId, ICredentials $credentials);
}