<?php
namespace Wl\Db\Pdo\Config;

class MysqlConfig implements IPdoConfig
{
    private $host;
    private $dbName;
    private $user;
    private $password;

    public function __construct($host, $dbName, $user, $password)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->user = $user;
        $this->password = $password;
    }

    public function getDsn()
    {
        return 'mysql:host='. $this->host . ';dbname=' . $this->dbName;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }
}