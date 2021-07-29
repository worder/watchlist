<?php

namespace Wl\User\Credentials;

class DigestToken implements ICredentials
{
    private $token;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function getToken()
    {
        return $this->login . '|' .  $this->password;
    }
}