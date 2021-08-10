<?php

namespace Wl\User\AccountValidator\Exception;

class AccountValidationException extends \Exception
{
    const USERNAME_EMPTY = 'USERNAME_EMPTY';
    const USERNAME_TOO_LONG = 'USERNAME_TOO_LONG';
    const USERNAME_TOO_SHORT = 'USERNAME_TOO_SHORT';
    const USERNAME_EXISTS = 'USERNAME_EXISTS';
    // const USERNAME_INVALID = 'USERNAME_INVALID';
    
    const EMAIL_EMPTY = 'EMAIL_EMPTY';
    const EMAIL_INVALID = 'EMAIL_INVALID';
    const EMAIL_EXISTS = 'EMAIL_EXISTS';
    
    const PASSWORD_EMPTY = 'PASSWORD_EMPTY';
    const PASSWORD_INVALID = 'PASSWORD_INVALID';


    private $_type;

    private function setType($type)
    {
        $this->_type = $type;
    }

    public function getType()
    {
        return $this->_type;
    }

    public static function create($type): AccountValidationException
    {
        $ex = new self();
        $ex->setType($type);
        return $ex;
    }
}