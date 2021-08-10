<?php

namespace Wl\User\Credentials;

class DigestCredentials extends Credentials
{
    private $password;

    public function setPassword($password): DigestCredentials
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}