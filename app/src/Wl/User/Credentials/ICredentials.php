<?php

namespace Wl\User\Credentials;

interface ICredentials
{
    public function getAccountId();
    public function getValue();
    public function getType();
}