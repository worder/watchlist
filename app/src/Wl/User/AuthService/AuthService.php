<?php

namespace Wl\User\AuthService;

use Wl\User\Account\IAccount;
use Wl\User\AccountService\IAccountService;
use Wl\User\AuthService\AuthStorage\IAuthStorage;
use Wl\User\Credentials\ICredentials;

class AuthService implements IAuthService
{
    private $accService;

    private $account;
    private $storage;


    public function __construct(IAccountService $accService, IAuthStorage $storage)
    {
        $this->accService = $accService;
        $this->storage = $storage;

        $this->account = $storage->loadAccount();
    }

    public function authenticate(ICredentials $credentials): ?IAccount
    {
        return $this->accService->getAccountByCredentials($credentials);
    }

    public function account(): ?IAccount
    {
        return $this->account;
    }

    public function login(IAccount $account)
    {
        $this->account = $account;
        $this->storage->saveAccount($account);
    }

    public function logout()
    {
        $this->account = null;
        $this->storage->reset();
    }
}