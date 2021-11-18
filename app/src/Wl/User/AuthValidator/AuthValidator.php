<?php

namespace Wl\User\AuthValidator;

use Wl\User\Credentials\ICredentials;
use Wl\User\AccountValidator\AccountValidator;
use Wl\User\Credentials\DigestCredentials;

class AuthValidator 
{
    public function validateCredentials(ICredentials $credentials)
    {
        try {
            AccountValidator::validateCredentials($credentials);
        } catch (\Exception $e) {
            throw AuthValidatorException::create(AuthValidatorException::TYPE_INVALID_PASSWORD);
        }
    }
}