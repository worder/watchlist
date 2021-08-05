<?php

namespace Wl\Db\Pdo;

interface IManipulator
{
    public function getRows($query, $params=[]);
    public function getRow($query, $params=[]);
    public function getValue($query, $params=[]);
    public function exec($query, $params=[]): IResult;
    public function prepare($query);
}