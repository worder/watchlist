<?php

namespace Wl\User\AccountValidator;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;

interface IAccountValidator
{
    const SCHEME_ADD = 'SCHEME_ADD';
    const SCHEME_EDIT = 'SCHEME_EDIT';

    public function validateAccount(IAccount $account, $scheme);   
    public function validateCredentials(ICredentials $credentials);
}