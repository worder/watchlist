<?php

namespace Wl\Lists\Subscription\ListSubscriptionService;

use Wl\Db\Pdo\IManipulator;
use Wl\List\ListSubscriptionService\IListSubscriptionService;
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
        return $this->getSubscriptionById($result->getId());
    }

    public function getSubscriptionById(int $id): ?IListSubscription
    {
        $q = "SELECT * FROM list_subscriptions WHERE id=:id";
        $result = $this->db->getRow($q, ['id' => $id]);
        if ($result) {
            return $this->buildSubscription($result);
        }

        return null;
    }

    private function buildSubscription($data)
    {
        $perms = PermissionsList::import(json_decode($data['permissions'], true));

        $sub = new ListSubscription();
        return $sub->setListId($data['listId'])
            ->setUserId($data['userId'])
            ->setAdded($data['added'])
            ->setPermissions($perms);
    }
}
