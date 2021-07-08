<?php
namespace Wl\Db\Pdo\Config;

interface IPdoConfig
{
    public function getDsn();
    public function getUser();
    public function getPassword();
}