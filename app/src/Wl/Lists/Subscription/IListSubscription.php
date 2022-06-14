<?php

namespace Wl\Lists\Subscription;

use Wl\Permissions\IPermissionsList;

interface IListSubscription 
{
    public function getListId(): int;
    public function getUserId(): int;
    public function getAdded(): string;
    public function getPermissions(): IPermissionsList;
}