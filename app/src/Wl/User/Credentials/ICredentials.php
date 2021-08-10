<?php

namespace Wl\User\Credentials;

interface ICredentials
{
    public function getValue();
    public function getType();
}