<?php

namespace Wl\User\Account;

interface IAccount
{
    public function getId();
    public function getName();
    public function getEmail();
}