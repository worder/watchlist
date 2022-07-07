<?php

namespace Wl\Lists\Subscription;

use Wl\Lists\IList;
use Wl\Permissions\IPermissionsList;

interface IListSubscription 
{
    public function getList(): ?IList;
    
    public function getListId(): int;
    public function getUserId(): int;
    public function getAdded(): string;
    public function getPermissions(): IPermissionsList;
}