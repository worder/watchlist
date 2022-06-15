<?php

namespace Wl\Lists\Subscription\ListSubscriptionService;

use Wl\Db\Pdo\IManipulator;
use Wl\Lists\Subscription\IListSubscription;
use Wl\Lists\Subscription\ListSubscription;
use Wl\Permissions\PermissionsList;

class ListSubscriptionService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function createSubscription(IListSubscription $sub): bool
    {
        $q = "INSERT INTO list_subscriptions (`listId`, `userId`, `added`, `permissions`) 
                   VALUES (:listId, :userId, :added, :permissions)";

        $result = $this->db->exec($q, [
            'listId' => $sub->getListId(),
            'userId' => $sub->getUserId(),
            'added' => date('Y-m-d H:i:s'),
            'permissions' => json_encode($sub->getPermissions()->getAll())
        ]);
        if ($result) {
            return true;
        }

        return false;
    }

    public function buildSubscription($data)
    {
        $perms = PermissionsList::import(json_decode($data['permissions'], true));

        $sub = new ListSubscription();
        return $sub->setListId($data['listId'])
            ->setUserId($data['userId'])
            ->setAdded($data['added'])
            ->setPermissions($perms);
    }
}
