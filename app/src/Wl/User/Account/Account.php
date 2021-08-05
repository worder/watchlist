<?php

namespace Wl\User\Account;

class Account implements IAccount
{
    private $id;
    private $username;
    private $email;

    public function __construct($data=[])
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['username'])) {
            $this->setUsername($data['username']);
        }
        if (isset($data['email'])) {
            $this->setEmail($data['email']);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    protected function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}