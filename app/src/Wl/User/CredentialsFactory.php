<?php

namespace Wl\User;

use Wl\User\Account\IAccount;
use Wl\User\Credentials\Credentials;
use Wl\User\Credentials\DigestCredentials;
use Wl\User\Credentials\ICredentials;
use Wl\Utils\Date\IDate;

class CredentialsFactory implements ICredentialsFactory
{
    private $salt;
    private $hashAlgo;

    public function __construct($salt)
    {
        $this->salt = $salt;
        $this->hashAlgo = 'haval128,3';
    }

    public function getDigestToken($login, $password): ICredentials
    {
        $base = "{$login}@{$password}@{$this->salt}";
        return new DigestCredentials(self::CREDENTIALS_TYPE_DIGEST, $this->hash($base), null,  $password);
    }

    public function getToken($value): ICredentials
    {
        return new Credentials(self::CREDENTIALS_TYPE_TOKEN, $value, null);
    }

    public function createToken(IDate $expire): ICredentials
    {
        return new Credentials(self::CREDENTIALS_TYPE_TOKEN, $this->hash(uniqid()), $expire);
    }

    private function hash($base)
    {
        return hash($this->hashAlgo, $base);
    }
}
