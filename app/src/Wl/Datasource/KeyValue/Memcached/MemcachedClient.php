<?php

namespace Wl\Datasource\KeyValue\Memcached;

use \Memcached as MemcacheLib;
use Wl\Datasource\KeyValue\IStorage;

class MemcachedClient implements IStorage
{
    private $pointer;

    public function __construct()
    {
        $this->pointer = new MemcacheLib();
    }

    public function addServer(MemcachedServer $server)
    {
        $this->pointer->addServer($server->getHost(), $server->getPort(), $server->getWeight());
    }

    public function get($key)
    {
        return $this->pointer->get('val:' . $key);
    }

    public function getExpirationTime($key)
    {
        return $this->pointer->get('ttl:' . $key);
    }

    public function add($key, $value, $expire = 0) 
    {
        if ($expire > 0) {
            $expire += \time();
        }
        if ($this->pointer->add('val:' . $key, $value, $expire)) {
            $this->pointer->set('ttl:' . $key, $expire, $expire);
            return true;
        }

        return false;
    }

    public function set($key, $value, $expire = 0)
    {
        if ($expire > 0 && $expire < \time()) {
            $expire += \time();
        }
        if ($this->pointer->set('val:' . $key, $value, $expire)) {
            $this->pointer->set('ttl:' . $key, $expire, $expire);
            return true;
        }

        return false;
    }

    public function delete($key)
    {
        if ($this->pointer->delete('val:' . $key, 0)) {
            $this->pointer->decrement('ttl:' . $key, 0);
            return true;
        }

        return false;        
    }

    public function flush()
    {
        $this->pointer->flush();
    }

    public function getStats()
    {
        return $this->pointer->getStats();
    }
}
