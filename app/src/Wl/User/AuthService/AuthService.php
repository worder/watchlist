<?php

namespace Wl\User\AuthService;

use Wl\User\Account\IAccount;
use Wl\User\AccountService\IAccountService;
use Wl\User\Credentials\ICredentials;

class AuthService implements IAuthService
{
    private $accService;

    private $account;

    public function __construct(IAccountService $accService)
    {
        $this->accService = $accService;
    }

    public function authenticate(ICredentials $credentials): ?IAccount
    {
        $acc = $this->accService->getAccountByCredentials($credentials);
        if ($acc) {
            $this->setAccount($acc);
            return $acc;
        }

        return null;
    }

    public function getAccount(): ?IAccount
    {
        return $this->account;
    }

    private function setAccount(IAccount $account)
    {
        $this->account = $account;
    }
}