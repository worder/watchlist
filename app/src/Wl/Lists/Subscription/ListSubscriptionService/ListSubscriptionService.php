<?php

namespace Wl\Lists\Subscription\ListSubscriptionService;

use Wl\Db\Pdo\IManipulator;
use Wl\Lists\Subscription\ListSubscriptionService\IListSubscriptionService;
use Wl\Lists\ListService\ListService;
use Wl\Lists\Subscription\IListSubscription;
use Wl\Lists\Subscription\ListSubscription;
use Wl\Permissions\PermissionsList;

class ListSubscriptionService implements IListSubscriptionService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function createSubscription(IListSubscription $sub): IListSubscription
    {
        $q = "INSERT INTO list_subscriptions (`listId`, `userId`, `added`, `permissions`) 
                   VALUES (:listId, :userId, :added, :permissions)";

        $result = $this->db->exec($q, [
            'listId' => $sub->getListId(),
            'userId' => $sub->getUserId(),
            'added' => date('Y-m-d H:i:s'),
            'permissions' => json_encode($sub->getPermissions()->getAll())
        ]);
        return $this->getSubscription($sub->getListId(), $sub->getUserId());
    }

    public function getSubscription(int $listId, int $userId): ?IListSubscription
    {
        $q = "SELECT * FROM list_subscriptions WHERE listId=:listId AND userId=:userId";
        $result = $this->db->getRow($q, ['listId' => $listId, 'userId' => $userId]);
        if ($result) {
            return $this->buildSubscription($result);
        }

        return null;
    }

    public function getUserSubscriptions(int $userId)
    {
        // `id` int(11) PRIMARY KEY AUTO_INCREMENT,
        // `ownerId` int(11) NOT NULL,
        // `title` text NOT NULL,
        // `description` text,
        // `added` datetime NOT NULL,
        // `updated` datetime NOT NULL
        $q = 'SELECT ls.`listId`, ls.`userId`, ls.`added`, ls.`permissions`, 
                     l.`id` AS `l_id`, 
                     l.`ownerId` AS `l_ownerId`, 
                     l.`title` AS `l_title`,
                     l.`description` AS `l_description`,
                     l.`added` AS `l_added`,
                     l.`updated` AS `l_updated`
                FROM list_subscriptions ls
          RIGHT JOIN lists l ON l.`id`=ls.`listId`
               WHERE ls.`userId`=:userId';

        $rows = $this->db->getRows($q, ['userId' => $userId]);

        $result = [];
        foreach ($rows as $row) {
            $listSub = $this->buildSubscription($row);

            $listData = [];
            foreach ($row as $key => $value) {
                if (strpos($key, 'l_') === 0) {
                    $listData[substr($key, 2)] = $value;
                }
            }

            $listSub->setList(ListService::buildList($listData));

            $result[] = $listSub;
        }

        return $result;
    }

    public static function buildSubscription($data)
    {
        $perms = PermissionsList::import(json_decode($data['permissions'], true));

        $sub = new ListSubscription();
        return $sub->setListId($data['listId'])
            ->setUserId($data['userId'])
            ->setAdded($data['added'])
            ->setPermissions($perms);
    }
}
