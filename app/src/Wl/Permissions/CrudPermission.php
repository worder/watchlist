<?php

namespace Wl\Permissions;

class CrudPermission implements IPermission
{
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    private $type;

    private function __construct($type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function create(): IPermission
    {
        return new self(self::CREATE);
    }

    public static function read(): IPermission
    {
        return new self(self::READ);
    }

    public static function update(): IPermission
    {
        return new self(self::UPDATE);
    }

    public static function delete(): IPermission
    {
        return new self(self::DELETE);
    }
}