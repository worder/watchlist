<?php

namespace Wl\User\AuthService\Exception;

class AuthException extends \Exception
{
    const INVALID_LOGIN = 'INVALID_LOGIN';
    const INVALID_PASSWORD = 'INVALID_PASSWORD';
    const INVALID_TOKEN = 'INVALID_TOKEN';

    // private $type;

    // private function __construct($type)
    // {
    //     $this->type = $type;
    // }

    // public function getType()
    // {
    //     return $this->type;
    // }

    static function invalidLogin()
    {
        return new self(self::INVALID_LOGIN);
    }

    static function invalidPassword()
    {
        return new self(self::INVALID_PASSWORD);
    }

    static function invalidToken()
    {
        return new self(self::INVALID_TOKEN);
    }
}