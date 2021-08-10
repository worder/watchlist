<?php

namespace Wl\User\Credentials;

class Credentials implements ICredentials
{
    private $type;
    private $value;

    public function __construct($data = [])
    {
        if (isset($data['type'])) {
            $this->setType($data['type']);
        }
        if (isset($data['value'])) {
            $this->setValue($data['value']);
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
