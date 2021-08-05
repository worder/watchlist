<?php

namespace Wl\Db\Pdo;

interface IResult
{
    public function getRow(): array;
    public function getAll(): array;
    public function getCount();
    public function getId();
}