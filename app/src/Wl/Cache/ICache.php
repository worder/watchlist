<?php

namespace Wl\Cache;

interface ICache 
{
    public function set($key, $value, $expire = 0);
    public function get($key);
    public function delete($key);
}