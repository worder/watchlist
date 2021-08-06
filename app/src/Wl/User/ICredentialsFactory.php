<?php

namespace Wl\User;

use Wl\User\Credentials\ICredentials;

interface ICredentialsFactory
{
    const CREDENTIALS_TYPE_DIGEST = 0;

    public function createDigestToken($login, $password): ICredentials;
}