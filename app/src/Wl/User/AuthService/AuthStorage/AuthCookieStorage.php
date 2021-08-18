<?php

namespace Wl\User\AuthService\AuthStorage;

use Wl\Http\HttpService\IHttpService;
use Wl\Session\ISession;
use Wl\User\Account\IAccount;
use Wl\User\AccountService\IAccountService;
use Wl\User\ICredentialsFactory;

class AuthCookieStorage implements IAuthStorage
{
    private $httpService;
    private $accService;
    private $credFactory;

    const AUTH_COOKIE_NAME = 'atoken';

    public function __construct(IHttpService $httpService, IAccountService $accService, ICredentialsFactory $credFactory)
    {
        $this->httpService = $httpService;
        $this->accService = $accService;
        $this->credFactory = $credFactory;
    }

    public function loadAccount(): ?IAccount
    {
        $token = $this->httpService->request()->cookies()->get(self::AUTH_COOKIE_NAME);
        $cred = $this->credFactory->createToken($token);
        return $this->accService->getAccountByCredentials($cred);
    }

    public function saveAccount(IAccount $account)
    {
        $token = $this->credFactory->generateToken();
    }

    public function reset()
    {
        
    }
}