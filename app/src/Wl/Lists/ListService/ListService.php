<?php

namespace Wl\Lists\ListService;

use Exception;
use Wl\Db\Pdo\IManipulator;
use Wl\Lists\IList;
use Wl\Lists\ListEntity;
use Wl\Lists\ListService\Exception\ListCreateException;

class ListService implements IListService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function createList(IList $list): IList
    {   
        // `id` int(11) PRIMARY KEY AUTO_INCREMENT,
        // `ownerId` int(11) NOT NULL,
        // `title` text NOT NULL,
        // `description` text,
        // `added` datetime NOT NULL,
        // `updated` datetime NOT NULL

        $q = "INSERT INTO lists (`ownerId`, `title`, `description`, `added`, `updated`) 
                   VALUES (:ownerId, :title, :desc, :added, :updated)";

        try {
            $result = $this->db->exec($q, [
                'ownerId' => $list->getOwnerId(),
                'title' => $list->getTitle(),
                'desc' => $list->getDesc(),
                'added' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
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
            return self::buildList($result);
        }

        return null;
    }

    public static function buildList(array $data): IList
    {
        $list = new ListEntity();
        return $list
            ->setOwnerId($data['ownerId'])
            ->setId($data['id'])
            ->setDesc($data['description'])
            ->setTitle($data['title'])
            ->setAdded($data['added'])
            ->setUpdated($data['updated']);
    }
}
