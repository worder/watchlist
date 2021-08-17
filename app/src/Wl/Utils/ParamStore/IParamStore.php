<?php

namespace Wl\Utils\ParamStore;

use Iterator;

interface IParamStore extends Iterator
{
    public function get($key);
    public function has($key);

    public function getAll();
}