<?php

namespace Wl\Permissions;

interface IPermissionsList 
{
    public function addPermission(IPermission $permission): void;
    public function hasPermission(IPermission $permission): bool;
    public function getAll(): array;
}