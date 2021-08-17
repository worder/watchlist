<?php

namespace Wl\User;

use Wl\User\Credentials\DigestCredentials;
use Wl\User\Credentials\ICredentials;

class CredentialsFactory implements ICredentialsFactory
{
    private $salt;
    private $hashAlgo;

    public function __construct($salt)
    {
        $this->salt = $salt;
        $this->hashAlgo = 'haval128,3';
    }

    public function createDigestToken($login, $password): ICredentials
    {
        $base = "{$login}@{$password}@{$this->salt}";
        $token = new DigestCredentials();
        return $token
            ->setValue(hash($this->hashAlgo, $base))
            ->setType(self::CREDENTIALS_TYPE_DIGEST)
            ->setPassword($password);
    }
}
