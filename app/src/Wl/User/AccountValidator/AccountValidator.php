<?php

namespace Wl\User\AccountValidator;

use Wl\User\Account\IAccount;
use Wl\User\AccountValidator\Exception\AccountValidationException as AWE;
use Wl\User\AccountService\IAccountService;
use Wl\User\Credentials\DigestCredentials;
use Wl\User\Credentials\ICredentials;

class AccountValidator implements IAccountValidator
{
    private $accService;

    const ACCOUNT_SCHEMES = [
        self::SCHEME_ADD,
        self::SCHEME_EDIT,
    ];

    public function __construct(IAccountService $accService)
    {
        $this->accService = $accService;
    }

    public function validateAccount(IAccount $account, $scheme)
    {
        if (!in_array($scheme, self::ACCOUNT_SCHEMES)) {
            throw new \Exception("Invalid validation scheme");
        }

        // username check
        $username = $account->getUsername();
        if (empty($username)) {
            throw AWE::create(AWE::USERNAME_EMPTY);
        }
        if (strlen($username) > 64) {
            throw AWE::create(AWE::USERNAME_TOO_LONG);
        }
        if (strlen($username) < 2) {
            throw AWE::create(AWE::USERNAME_TOO_SHORT);
        }

        // email check
        $email = $account->getEmail();
        if (empty($email)) {
            throw AWE::create(AWE::EMAIL_EMPTY);
        }
        if (!preg_match("#^[a-z0-9-_\.]+@[a-z0-9-_\.]+$#i", $email)) {
            throw AWE::create(AWE::EMAIL_INVALID);
        }

        // before add checks
        if ($scheme === self::SCHEME_ADD) {
            if ($this->accService->getAccountByEmail($email)) {
                throw AWE::create(AWE::EMAIL_EXISTS);
            }
            if ($this->accService->getAccountByUsername($username)) {
                throw AWE::create(AWE::USERNAME_EXISTS);
            }
        }

        return true;
    }

    public function validateCredentials(ICredentials $credentials)
    {
        if ($credentials instanceof DigestCredentials) {
            $password = $credentials->getPassword();
            if (empty($password)) {
                throw AWE::create(AWE::PASSWORD_EMPTY);
            }
        }

        return true;
    }
}