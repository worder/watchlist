<?php

namespace Wl\Permissions;

class PermissionsList implements IPermissionsList
{
    private $permissions;

    public function addPermission(IPermission $permission): void
    {
        $this->permissions[] = $permission->getType();
    }

    public function hasPermission(IPermission $permission): bool
    {
        return in_array($permission->getType(), $this->permissions);
    }

    public function getAll(): array
    {
        return array_unique($this->permissions);
    }

    private function setPermissions(array $values)
    {
        $this->permissions = $values;
    }

    public static function import(array $values)
    {
        $list = new self();
        $list->setPermissions($values);
        return $list;
    }
}
