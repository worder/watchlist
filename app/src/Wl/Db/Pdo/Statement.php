<?php
namespace Wl\Db\Pdo;

use \Exception;

class Statement implements IStatement
{
    private $pdo;
    private $statement;
    private $query;

    private $valuesCounter = 1;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /*
     * Must be called only inside pdo method
     *
     * @param string $query - SQL query
     *
     * */
    public function prepare($query)
    {
        $statement = $this->pdo->prepare($query);
        $this->statement = $statement;
        $this->query = $query;
    }


    /*
     * Bind statement value
     *
     * User this to bind
     *
     * @param mixed $value - statement value
     * @param string [$placeholder] - placeholder name (if named placeholders used)
     *
     * */
    function bindParam($value, $placeholder=false): IStatement
    {
        if (!$placeholder) {
            $placeholder = $this->valuesCounter;
        }
        $this->statement->bindValue($placeholder, $value);
        $this->valuesCounter++;

        return $this;
    }


    /*
     * Executes statement
     *
     * @return object Db_Pdo_Result
     *
     * */
    function execute(): IResult
    {
        $flag =  $this->statement->execute();
        if ($flag) {
            return new Result($this->statement, $this->pdo);
        } else {
            throw new Exception("Database query failed: " . print_r($this->statement->errorInfo(), true) . "\n Qeury: {$this->query}");
        }
    }
}