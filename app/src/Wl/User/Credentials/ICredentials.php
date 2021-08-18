<?php

namespace Wl\User\Credentials;

use Wl\Utils\Date\IDate;

interface ICredentials
{
    public function getValue();
    public function getType();
    public function getExpire(): IDate;
}