<?php

namespace Wl\User\Credentials;

use Wl\Utils\Date\IDate;

class DigestCredentials extends Credentials
{
    private $password;

    public function __construct($type, $value, ?IDate $expire, $password)
    {
        parent::__construct($type, $value, $expire);
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
}