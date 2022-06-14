<?php

namespace Wl\Permissions;

interface IPermission
{
    public function getType(): string;
}