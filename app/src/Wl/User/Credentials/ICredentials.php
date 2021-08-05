<?php

namespace Wl\User\Credentials;

interface ICredentials
{
    const TYPE_DIGEST = 0;

    public function getAccountId();
    public function getValue();
    public function getType();
}