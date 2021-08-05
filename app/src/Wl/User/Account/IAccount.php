<?php

namespace Wl\User\Account;

interface IAccount
{
    public function getId();
    public function getUsername();
    public function getEmail();
}