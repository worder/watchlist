<?php

namespace Wl\User\AuthStorage;

use Wl\User\Account\IAccount;

class AuthCompositeStorage implements IAuthStorage
{
    private $backends = [];

    public function __construct(array $backends)
    {
        foreach ($backends as $backend) {
            $this->addBackend($backend);
        }
    }

    protected function addBackend(IAuthStorage $backend)
    {
        $this->backends[] = $backend;
    }

    public function loadAccount(): ?IAccount
    {
        foreach ($this->backends as $b) {
            $acc = $b->loadAccount();
            if ($acc) {
                return $acc;
            }
        }

        return null;
    }

    public function saveAccount(IAccount $account)
    {
        foreach ($this->backends as $b) {
            $b->saveAccount($account);
        }
    }

    public function reset(): void
    {
        foreach ($this->backends as $b) {
            $b->reset();
        }
    }
}