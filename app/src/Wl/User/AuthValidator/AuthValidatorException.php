<?php

namespace Wl\User\AuthValidator;

class AuthValidatorException extends \Exception 
{
    const TYPE_INVALID_PASSWORD = 'TYPE_INVALID_PASSWORD';

    public static function create($type)
    {
        return new self($type);
    }
}