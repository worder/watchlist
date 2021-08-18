<?php

namespace Wl\User;

use Wl\User\Credentials\ICredentials;
use Wl\Utils\Date\IDate;

interface ICredentialsFactory
{
    const CREDENTIALS_TYPE_DIGEST = 0;
    const CREDENTIALS_TYPE_TOKEN = 1;

    public function getDigestToken($login, $password): ICredentials;
    public function getToken($value): ICredentials;

    public function createToken(IDate $expire): ICredentials;
}