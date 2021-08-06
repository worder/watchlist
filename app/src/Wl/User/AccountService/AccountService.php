<?php

namespace Wl\User\AccountService;

use Wl\Db\Pdo\IManipulator;
use Wl\User\Account\Account;
use Wl\User\Account\IAccount;
use Wl\User\Credentials\ICredentials;
use Wl\User\Exception\AccountCreateException;
use Wl\User\Exception\EmailCollisionException;

class AccountService implements IAccountService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function getAccountByCredentials(ICredentials $credencials): ?IAccount
    {
        $accData = $this->db->getRow("
            SELECT a.* 
              FROM accounts a 
        RIGHT JOIN token t ON a.id=t.accountId
             WHERE t.value=:value", ["value" => $credencials->getValue()]);

        return $accData ? $this->buildAccount($accData) : null;
    }

    public function getAccountById($id): ?IAccount
    {
        $accData = $this->db->getRow(
            "SELECT id, username, email
               FROM accounts
              WHERE id=:id",
            ["id" => intval($id)]
        );

        return $accData ? $this->buildAccount($accData) : null;
    }

    public function getAccountByEmail($email)
    {
        $accData = $this->db->getRow(
            "SELECT id, username, email
               FROM accounts
              WHERE email=:email",
            ["email" => $email]
        );

        return $accData ? $this->buildAccount($accData) : null;
    }

    public function addAccount(IAccount $acc): IAccount
    {
        if ($this->getAccountByEmail($acc->getEmail())) {
            throw new EmailCollisionException();
        }

        $q = "INSERT INTO account (`email`, `username`, `added`) 
                   VALUES (:email, :username, :added)";

        $accResult = $this->db->exec($q, [
            'email' => $acc->getEmail(),
            'username' => $acc->getUsername(),
            'added' => date("Y-m-d H:i:s")
        ]);

        if ($accResult) {
            $acc = $this->getAccountById($accResult->getId());
            if ($acc) {
                return $acc;
            }
        } 

        throw new AccountCreateException();
    }

    public function validateAccount(IAccount $account)
    {
        return true; // TODO
    }

    public function addCredentials(ICredentials $credentials)
    {
        $q = "INSERT INTO credentials (`accountId`, `type`, `value`) VALUES (:id, :type, :value)";
        $this->db->exec($q, ['id' => $credentials->get]);
    }

    public function validateCredentials(ICredentials $credentials)
    {
        return true; // TODO
    }

    protected function buildAccount($data)
    {
        return new Account($data);
    }
}
