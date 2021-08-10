<?php

namespace Wl\User\AccountService;

use Wl\Db\Pdo\IManipulator;
use Wl\User\Account\Account;
use Wl\User\Account\IAccount;
use Wl\User\AccountService\Exception\AccountCreateException;
use Wl\User\AccountService\Exception\CredentialsCreateException;
use Wl\User\Credentials\ICredentials;

class AccountService implements IAccountService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function getAccountByCredentials(ICredentials $credencials): ?IAccount
    {
        $accData = $this->db->getRow(
            "SELECT a.* 
               FROM accounts a 
         RIGHT JOIN credentials c ON a.id=c.accountId
              WHERE c.value=:value", ["value" => $credencials->getValue()]);

        return $accData ? $this->buildAccount($accData) : null;
    }

    public function getAccountById($id): ?IAccount
    {
        return $this->getAccountByField("id", $id);
    }

    public function getAccountByEmail($email): ?IAccount
    {
        return $this->getAccountByField("email", $email);
    }

    public function getAccountByUsername($username): ?IAccount
    {
        return $this->getAccountByField("username", $username);
    }

    private function getAccountByField($field, $value): ?IAccount
    {
        $accData = $this->db->getRow(
            "SELECT id, username, email
               FROM accounts
              WHERE {$field}=:val",
            ["val" => $value]
        );

        return $accData ? $this->buildAccount($accData) : null;
    }


    public function addAccount(IAccount $acc): IAccount
    {
        $q = "INSERT INTO accounts (`email`, `username`, `added`) 
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

    public function addCredentials($accountId, ICredentials $credentials)
    {
        $q = "INSERT INTO credentials (`accountId`, `type`, `value`) 
              VALUES (:id, :type, :value)";
        $this->db->exec($q, [
            'id' => $accountId,
            'type' => $credentials->getType(),
            'value' => $credentials->getValue()
        ]);

        return true; // or db exeption
    }

    protected function buildAccount($data)
    {
        return new Account($data);
    }
}
