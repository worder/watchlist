<?php

namespace Wl\User\Credentials;

use Wl\Utils\Date\IDate;

class DigestCredentials extends Credentials
{
    private $password;
    private $login;

    public function __construct($type, $value, ?IDate $expire, $login, $password)
    {
        parent::__construct($type, $value, $expire);
        $this->password = $password;
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }
}