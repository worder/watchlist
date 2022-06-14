<?php

namespace Wl\Db\Pdo;

interface IManipulator
{
    public function getRows($query, $params=[]): array;
    public function getRow($query, $params=[]): array;
    public function getValue($query, $params=[]);
    public function exec($query, $params=[]): IResult;
    public function prepare($query): IStatement;
}