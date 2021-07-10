<?php

namespace Wl\Datasource\KeyValue;

interface IStorage 
{
    public function add($key, $value, $expire = 0);
    public function set($key, $value, $expire = 0);
    public function getExpirationTime($key);
    public function get($key);
    public function delete($key);
}