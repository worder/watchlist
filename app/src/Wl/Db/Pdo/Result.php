<?php
namespace Wl\Db\Pdo;

use \PDO;

class Result implements IResult
{
    private $statement;
    private $pdo;

    public function __construct($statement, $pdo)
    {
        $this->statement = $statement;
        $this->pdo = $pdo;
    }


    /*
     * Fetch one row
     *
     * @return array
     *
     * */
    public function getRow(): array
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }


    /*
     * Fetch all rows
     *
     * @return array
     *
     * */
    public function getAll(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * Get afected rows count
     *
     * @return int
     *
     * */
    public function getCount()
    {
        return $this->statement->rowCount();
    }


    /*
     * Returns last insert ID
     *
     * @return string
     *
     * */
    public function getId()
    {
        return $this->pdo->lastInsertId();
    }
}