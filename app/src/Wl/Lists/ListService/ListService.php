<?php

namespace Wl\Lists\ListService;

use Exception;
use Wl\Db\Pdo\IManipulator;
use Wl\Lists\IList;
use Wl\Lists\ListEntity;
use Wl\Lists\ListService\Exception\ListCreateException;

class ListService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function createList(IList $list)
    {
        $q = "INSERT INTO lists (`title`, `description`, `added`) 
                   VALUES (:title, :desc, :added)";

        try {
            $result = $this->db->exec($q, [
                'title' => $list->getTitle(),
                'desc' => $list->getDesc(),
                'added' => date('Y-m-d H:i:s'),
            ]);

            if ($result) {
                return $this->getListById($result->getId());
            }
        } catch (Exception $e) {
            throw new ListCreateException($e->getMessage());
        }
    }

    public function getListById($id): ?IList
    {
        $q = "SELECT * FROM lists WHERE id=:id";

        $result = $this->db->getRow($q, ['id' => $id]);
        if ($result) {
            return $this->buildList($result);
        }

        return null;
    }

    private function buildList(array $data): IList
    {
        $list = new ListEntity();
        return $list->setId($data['id'])->setDesc($data['description'])->setTitle($data['title']);
    }
}
