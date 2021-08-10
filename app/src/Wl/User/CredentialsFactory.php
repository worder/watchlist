<?php

namespace Wl\User;

use Wl\User\Credentials\DigestCredentials;
use Wl\User\Credentials\ICredentials;

class CredentialsFactory implements ICredentialsFactory
{
    private $salt;

    public function __construct($salt)
    {
        $this->salt = $salt;
    }

    public function createDigestToken($login, $password): ICredentials
    {
        $base = "{$login}@{$password}@{$this->salt}";
        $token = new DigestCredentials();
        return $token
            ->setValue(md5($base))
            ->setType(self::CREDENTIALS_TYPE_DIGEST)
            ->setPassword($password);
    }
}
