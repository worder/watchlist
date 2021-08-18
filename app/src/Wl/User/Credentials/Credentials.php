<?php

namespace Wl\User\Credentials;

use Wl\Utils\Date\IDate;

class Credentials implements ICredentials
{
    private $type;
    private $value;
    private $expire;

    public function __construct($type, $value, ?IDate $expire)
    {
        $this->type = $type;
        $this->value = $value;
        $this->expire = $expire;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getExpire(): ?IDate
    {
        return $this->expire;
    }
}
