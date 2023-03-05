<?php

namespace Wl\Lists\ListItems\ListItemsService;

use Exception;
use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Db\Pdo\IManipulator;
use Wl\Lists\ListItems\IListItem;
use Wl\Lists\ListItems\IListItems;
use Wl\Lists\ListItems\ListItem;
use Wl\Lists\ListItems\ListItems;
use Wl\Lists\ListItems\ListItemStatus\IListItemStatus;
use Wl\Lists\ListItems\ListItemStatus\ListItemStatus;
use Wl\Media\ApiDataContainer\ApiDataContainer;
use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\MediaLocale\IMediaLocaleRecord;
use Wl\Media\MediaLocale\MediaLocaleRecord;
use Wl\Utils\Date\Date;

class ListItemsService implements IListItemsService
{
    /**
     * @Inject
     * @var IManipulator
     */
    private $db;

    /**
     * @Inject
     * @var ApiAdapterFactory
     * */
    private $apiAdapterFactory;


    public function getListItems(int $listId, string $locale, int $limit, int $offset): IListItems
    {
        // select items from a specific list

        $countQ = "SELECT count(*) FROM list_items WHERE listId=:listId";
        $total = $this->db->getValue($countQ, ['listId' => $listId]);

        $listItems = new ListItems($limit, $offset, $total);

        $q = "SELECT mc.api AS mc_api, 
                     mc.mediaId AS mc_mediaId,
                     mc.locale AS mc_locale,
                     mc.data AS mc_data,
                     mc.title AS mc_title,
                     mc.added AS mc_added,
                     mc.updated AS mc_updated,
                     it.id AS item_id,
                     it.listId AS item_listId,
                     it.added AS item_added,
                     st.id AS status_id,
                     st.type AS status_type,
                     st.date AS status_date,
                     st.added AS status_added,
                     st.userId AS status_userId,
                     st.value AS status_value
                FROM media_cache mc 
          RIGHT JOIN list_items it
                     ON it.api=mc.api
                     AND it.mediaId=mc.mediaId 
                     AND mc.locale=:locale
          RIGHT JOIN list_item_statuses st
                     ON st.itemId=it.id
               WHERE it.listId=:listId
            GROUP BY mc.api, 
                     mc.mediaId
            ORDER BY st.type DESC, 
                     st.date DESC
               LIMIT :offset, :limit";

        $rows = $this->db->getRows($q, [
            'locale' => $locale,
            'listId' => $listId,
            'offset' => $offset,
            'limit' => $limit
        ]);

        foreach ($rows as $row) {
            $listItems->addItem($this->buildListItemFromRow($row));
        }

        return $listItems;
    }

    public function getUserMainPageItems(int $userId, string $locale, int $offset, int $limit): IListItems
    {
        // select items from all lists

        $totalQ = "SELECT count(it.id) 
                     FROM list_items it
               RIGHT JOIN media_cache mc 
                          ON it.api=mc.api
                          AND it.mediaId=mc.mediaId 
                          AND mc.locale=:locale
               RIGHT JOIN list_subscriptions sub
                       ON sub.listId=it.listId
               RIGHT JOIN list_item_statuses st
                       ON st.id=(SELECT s.id FROM list_item_statuses s WHERE s.itemId=it.id ORDER BY s.date DESC LIMIT 1)
                    WHERE sub.userId=:userId";

        $total = $this->db->getValue($totalQ, ['userId' => $userId, 'locale' => $locale]);

        $listItems = new ListItems($limit, $offset, $total);

        $q = "SELECT mc.api AS mc_api, 
                     mc.mediaId AS mc_mediaId,
                     mc.locale AS mc_locale,
                     mc.data AS mc_data,
                     mc.title AS mc_title,
                     mc.added AS mc_added,
                     mc.updated AS mc_updated,
                     it.id AS item_id,
                     it.listId AS item_listId,
                     it.added AS item_added,
                     st.id AS status_id,
                     st.type AS status_type,
                     st.added AS status_added,
                     st.date AS status_date,
                     st.userId AS status_userId,
                     st.value AS status_value
                FROM list_items it
          RIGHT JOIN media_cache mc 
                     ON it.api=mc.api
                     AND it.mediaId=mc.mediaId 
                     AND mc.locale=:locale
          RIGHT JOIN list_subscriptions sub
                     ON sub.listId=it.listId
          RIGHT JOIN list_item_statuses st
                     ON st.id=(SELECT s.id FROM list_item_statuses s WHERE s.itemId=it.id ORDER BY s.date DESC LIMIT 1)
               WHERE sub.userId=:userId 
            ORDER BY st.type DESC, 
                     st.date DESC,
                     st.added DESC
               LIMIT :offset, :limit";

        $rows = $this->db->getRows($q, [
            'userId' => $userId,
            'locale' => $locale,
            'offset' => $offset,
            'limit' => $limit
        ]);

        foreach ($rows as $row) {
            $listItem = new ListItem(
                $row['item_id'],
                $row['item_listId'],
                $this->buildMediaLocaleFromRow($row),
                $this->buildListItemStatusFromRow($row)
            );
            $listItems->addItem($listItem);
        }

        return $listItems;
    }

    private function buildListItemStatusFromRow($row): IListItemStatus
    {
        return new ListItemStatus(
            (int) $row['status_id'],
            (int) $row['status_type'],
            (int) $row['item_id'],
            (int) $row['status_userId'],
            json_decode($row['status_value']),
            Date::fromDate($row['status_added']),
            Date::fromDate($row['status_date'])
        );
    }

    private function buildListItemFromRow($row): IListItem
    {
        return new ListItem(
            $row['item_id'],
            $row['item_listId'],
            $this->buildMediaLocaleFromRow($row),
            $this->buildListItemStatusFromRow($row)
        );
    }

    private function buildMediaLocaleFromRow($row): IMediaLocaleRecord
    {
        $dataContainer = ApiDataContainer::import($row['mc_data']);
        $mediaLocale = new MediaLocaleRecord();
        $mediaLocale->setAdded(Date::fromDate($row['mc_added']));
        $mediaLocale->setUpdated(Date::fromDate($row['mc_updated']));
        $this->apiAdapterFactory->getAdapter($row['mc_api'])->buildMediaLocale($mediaLocale, $dataContainer);
        return $mediaLocale;
    }

    public function addListItem(int $listId, string $api, int $mediaId): int
    {
        $error = false;
        if (empty($listId)) {
            $error = "listId";
        } elseif (empty($mediaId)) {
            $error = "mediaId";
        } elseif (empty($api)) {
            $error = "api";
        }
        if ($error) {
            throw new Exception("empty_" . $error);
        }

        $q = "INSERT INTO list_items (`listId`, `api`, `mediaId`, `added`) 
                   VALUES (:listId, :api, :mediaId, :added)";

        $res = $this->db->exec($q, [
            'listId' => $listId,
            'api' => $api,
            'mediaId' => $mediaId,
            'added' => Date::now()->date()
        ]);
        return $res->getId();
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

    public function addListItemStatus(int $itemId, int $type, int $userId, string $date, $value = null): int
    {
        $q = "INSERT INTO list_item_statuses (`itemId`, `date`, `added`, `type`, `value`, `userId`) 
                   VALUES (:itemId, :date, :added, :type, :value, :userId)";

        $valueJson = json_encode($value);

        return $this->db->exec($q, [
            'itemId' => $itemId,
            'date' => $date,
            'added' => Date::now()->date(),
            'type' => $type,
            'value' => $valueJson,
            'userId' => $userId
        ])->getId();
    }
}
