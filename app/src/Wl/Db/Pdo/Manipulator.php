<?php
namespace Wl\Db\Pdo;

use \Exception;
use \PDO;
use Wl\Db\Pdo\Config\IPdoConfig;

class Manipulator implements IManipulator
{
    public $pdo = false;
    public $queriesCount = 0;

    public function __construct(IPdoConfig $config)
    {
        try {
            $this->pdo = new PDO($config->getDsn(), $config->getUser(), $config->getPassword());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if (!$this->pdo) {
            throw new Exception('PDO Failed to init');
        }
    }

    /**
     * Quick Fetch method - All rows
     *
     * @param string $query - SQL query
     * @param array [$params] - statement values
     *
     * @return array
     *
     * */
    public function getRows($query, $params=array())
    {
        return $this->exec($query, $params)->getAll();
    }

    /**
     * Quick Fetch method - One(first) row
     *
     * @param string $query - SQL query
     * @param array [$params] - statement values
     *
     * @return array
     *
     * */
    public function getRow($query, $params=array())
    {
        $row = array();
        $rows = $this->getRows($query, $params);
        if (isset($rows[0])) {
            $row = $rows[0];
        }

        return $row;
    }

    public function getValue($query, $params=array())
    {
        $value = false;
        $row = $this->getRow($query, $params);
        if (!empty($row)) {
            reset($row);
            $value = current($row);
        }

        return $value;
    }

    /**
     * Quick SQL executing
     *
     * @param string $query - SQL query
     * @param array [$params] - statement values
     * @return Worder\Db\Pdo\IResult
     *
     * */
    public function exec($query, $params=array()): IResult
    {
        $s = $this->prepare($query);
        foreach ($params as $placeholder => $value) {
            if (is_numeric($placeholder)) {
                $s->bindParam($value);
            } else {
                $s->bindParam($value, $placeholder);
            }
        }
        $result = $s->execute();
        $this->queriesCount++;
        return $result;
    }

    /**
     * Prepare statement method
     *
     * @param string $query - SQL query
     * @return Worder\Db\Pdo\Statement
     *
     * */
    public function prepare($query)
    {
        $statement = new Statement($this->pdo);
        $statement->prepare($query);
        return $statement;
    }
}