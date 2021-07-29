<?php

namespace Wl\User;

use Wl\User\Account\IAccount;

interface IAccountService
{
    public function getAccountById($id): ?IAccount;
    public function getAccountByAuthToken($token): ?IAccount;

    public function createAccount(IAccount $accountData);
}