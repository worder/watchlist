<?php

namespace Wl\Lists\ListItems\ListItemsService;

use Exception;
use Wl\Db\Pdo\IManipulator;
use Wl\Lists\ListItems\IListItem;
use Wl\Lists\ListItems\IListItems;
use Wl\Lists\ListItems\ListItemFeature\IListItemFeature;
use Wl\Lists\ListItems\ListItems;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;
use Wl\Lists\ListItems\ListItemStatus\ListItemsStatus;
use Wl\Utils\Date\Date;

class ListItemsService implements IListItemsService
{
    /**
     * @Inject
     * @var IManipulator
     */
    private $db;


    public function getListItems($listId, $locale, $limit, $offset): IListItems
    {
        $q = "SELECT count(*) FROM list_items WHERE listId=:listId";
        $total = $this->db->getValue($q);

        $countQ = "SELECT count(*) FROM list_items WHERE listId=:listId";
        $total = $this->db->getValue($countQ, ['listId' => $listId]);

        $listItems = new ListItems($limit, $offset, $total);

        $q = "SELECT mc.api AS mc_api, 
                     mc.mediId AS mc_mediaId 
                     mc.locale AS mc_locale,
                     mc.data AS mc_data,
                     mc.title AS mc_title,
                     mc.added AS mc.added,
                     mc.updated AS mc_updated,
                     li.id AS li_id,
                     li.listId AS li_listId,
                     li.added AS li_added,
                FROM media_cache mc 
          RIGHT JOIN list_items li 
                     ON li.api=mc.api
                     AND li.mediaId=mc.mediaId 
                     AND mc.locale=:locale
          RIGHT JOIN list_item_statuses lis
                     ON lis.itemId=li.itemId
               WHERE li.listId=:listId
            GROUP BY mc.api, 
                     mc.mediaId
            ORDER BY list.type DESC, 
                     lis.date DESC
               LIMIT :offset :limit";

        $rows = $this->db->getRows($q, [
            'locale' => $locale,
            'listId' => $listId,
            'offset' => $offset,
            'limit' => $limit
        ]);

        var_dump($rows);

        return $listItems;
    }

    private function buildListItemFromRow($row)
    {
        
    }

    public function addListItem(int $listId, string $api, int $mediaId, int $statusType, string $date, int $userId): int
    {
        $error = false;
        if (empty($listId) || empty($mediaId) || empty($api) || empty($userId)) {
            $error = "listId";
        } elseif (empty($mediaId)) {
            $error = "mediaId";
        } elseif (empty($api)) {
            $error = "api";
        } elseif (empty($userId)) {
            $error = "userId";
        }
        if ($error) {
            throw new Exception("Invalid data, empty " . $error);
        }

        $q = "INSERT INTO list_items (`listId`, `api`, `mediaId`, `added`) VALUES (:listId, :api, :mediaId, :added)";

        $res = $this->db->exec($q, [
            'listId' => $listId,
            'api' => $api,
            'mediaId' => $mediaId,
            'added' => Date::now()->date()
        ]);
        $itemId = $res->getId();

        $this->addListItemStatus($itemId, $date, $statusType, null, $userId);

        return $itemId;
    }

    public function addListFeature(int $itemId, int $type, $value, int $userId): int
    {
        $q = "INSERT INTO list_item_features (`itemId`, `userId`, `type`, `value`, `added`) 
                   VALUES (:itemId, :userId, :type, :value, :added)";

        return $this->db->exec($q, [
            'itemId' => $itemId,
            'type' => $type,
            'value' => $value,
            'userId' => $userId,
            'added' => Date::now()->date()
        ])->getId();
    }

    public function deleteListItem($itemId): void
    {
        $this->db->exec("DELETE FROM list_items WHERE itemId=:itemId", ['itemId' => $itemId]);
        $this->db->exec("DELETE FROM list_item_features WHERE itemId=:itemId", ['itemId' => $itemId]);
        $this->db->exec("DELETE FROM list_item_statuses WHERE itemId=:itemId", ['itemId' => $itemId]);
    }

    public function addListItemStatus(int $itemId, string $date, int $type, $value, int $userId): int
    {
        $q = "INSERT INTO list_item_statuses (`itemId`, `date`, `added`, `type`, `value`, `userId`) 
                   VALUES (:itemId, :date, now(), :type, :value, :userId)";

        $valueJson = json_encode($value);

        return $this->db->exec($q, [
            'itemId' => $itemId,
            'date' => $date,
            'type' => $type,
            'value' => $valueJson,
            'userId' => $userId
        ])->getId();
    }
}
