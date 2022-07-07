<?php

namespace Wl\Lists\Subscription;

use Wl\Lists\IList;
use Wl\Permissions\IPermissionsList;

class ListSubscription implements IListSubscription
{
    private $list = null;

    private $listId;
    private $userId;
    private $added;
    private $permissions;

    public function setList(IList $list)
    {
        $this->list = $list;
    }

    public function getList(): ?IList
    {
        return $this->list;
    }

    public function getListId(): int
    {
        return $this->listId;
    }

    public function setListId($listId): ListSubscription
    {
        $this->listId = $listId;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId($userId): ListSubscription
    {
        $this->userId = $userId;
        return $this;
    }

    public function getAdded(): string
    {
        return $this->added;
    }

    public function setAdded($added): ListSubscription
    {
        $this->added = $added;
        return $this;
    }

    public function getPermissions(): IPermissionsList
    {
        return $this->permissions;
    }

    public function setPermissions(IPermissionsList $permissions): ListSubscription
    {
        $this->permissions = $permissions;
        return $this;
    }
}
