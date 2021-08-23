<?php

namespace Wl\User\AuthStorage;

use Wl\Session\ISession;
use Wl\User\Account\IAccount;
use Wl\User\AccountService\IAccountService;

class AuthSessionStorage implements IAuthStorage
{
    private $session;
    private $accService;

    const SESSION_USER_KEY = 'AUTH_USER_ID';

    public function __construct(ISession $session, IAccountService $accService)
    {
        $this->session = $session;
        $this->accService = $accService;
    }

    public function loadAccount(): ?IAccount
    {
        $this->session->startSession();
        $userId = $this->session->get(self::SESSION_USER_KEY);
        $this->session->stopSession();
        if (!empty($userId)) {
            return $this->accService->getAccountById($userId);
        }
        return null;
    }

    public function saveAccount(IAccount $account)
    {
        $this->session->startSession();
        $this->session->set(self::SESSION_USER_KEY, $account->getId());
        $this->session->stopSession();
    }

    public function reset(): void
    {
        $this->session->startSession();
        $this->session->set(self::SESSION_USER_KEY, false);
        $this->session->stopSession();
    }
}