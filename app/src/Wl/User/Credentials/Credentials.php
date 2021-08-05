<?php

namespace Wl\User\Credentials;

class Credentials implements ICredentials
{
   
    private $accountId;
    private $type;
    private $value;

    public function __construct($data)
    {
        if (isset($data['accountId'])) {
            $this->accountId = $data['accountId'];
        }
        if (isset($data['type'])) {
            $this->type = $data['type'];
        }
        if (isset($data['value'])) {
            $this->value = $data['value'];
        }
        
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }
}