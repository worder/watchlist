<?php

namespace Wl\User\AuthStorage;

use Wl\Http\HttpService\IHttpService;
use Wl\User\Account\IAccount;
use Wl\User\AccountService\IAccountService;
use Wl\User\ICredentialsFactory;
use Wl\Utils\Date\Date;

class AuthCookieStorage implements IAuthStorage
{
    private $httpService;
    private $accService;
    private $credFactory;

    const AUTH_COOKIE_NAME = 'atoken';

    public function __construct(
        IHttpService $httpService,
        IAccountService $accService,
        ICredentialsFactory $credFactory
    ) {
        $this->httpService = $httpService;
        $this->accService = $accService;
        $this->credFactory = $credFactory;
    }

    public function loadAccount(): ?IAccount
    {
        $token = $this->httpService->request()->cookies()->get(self::AUTH_COOKIE_NAME);
        if (!empty($token)) {
            $cred = $this->credFactory->getToken($token);
            return $this->accService->getAccountByCredentials($cred);
        }
        return null;
    }

    public function saveAccount(IAccount $account)
    {
        $accountId = $account->getId();
        $token = $this->accService->getCredentialsByType($accountId, ICredentialsFactory::CREDENTIALS_TYPE_TOKEN);
        $expire = Date::now()->plusMonths(2);
        if (empty($token)) {
            $token = $this->credFactory->createToken($expire);
            $this->accService->addCredentials($accountId, $token);
        }

        setcookie(self::AUTH_COOKIE_NAME, $token->getValue(), $expire->timestamp(), "/", "", false, true);
    }

    public function reset(): void
    {
        setcookie(self::AUTH_COOKIE_NAME, '', 0, "/", "", true, true);
    }
}
