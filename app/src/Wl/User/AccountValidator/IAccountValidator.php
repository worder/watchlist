<?php

namespace Wl\User\AccountValidator;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAccountValidator
{
    const ACCOUNT_VALIDATION_SCHEME_ADD = 'ACCOUNT_VALIDATION_SCHEME_ADD';
    const ACCOUNT_VALIDATION_SCHEME_EDIT = 'ACCOUNT_VALIDATION_SCHEME_EDIT';

    public function validateAccount(IAccount $account, $scheme);   
    public function validateCredentials(ICredentials $credentials);
}