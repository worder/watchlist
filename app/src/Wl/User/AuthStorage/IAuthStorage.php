<?php

namespace Wl\User\AuthStorage;

use Wl\User\Account\IAccount;

interface IAuthStorage
{
    public function loadAccount(): ?IAccount;
    public function saveAccount(IAccount $account);
    public function reset(): void;
}