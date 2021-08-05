<?php

namespace Wl\Db\Pdo;

use Wl\Datasource\KeyValue\IStorage;

interface IStatement
{
    public function prepare($query);
    public function bindParam($value, $placeholder=false): IStatement;
    public function execute(): IResult;
}