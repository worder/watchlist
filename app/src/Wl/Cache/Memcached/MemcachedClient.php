<?php
namespace Wl\Cache\Memcached;

use \Memcached as MemcacheLib;
use Wl\Cache\ICache;

class MemcachedClient implements ICache
{
    private $pointer;
    private $prefix = 'php_';

    // private $servers = [];

    public function __construct()
    {
        $this->pointer = new MemcacheLib();
    }

    public function addServer(MemcachedServer $server)
    {
        $this->pointer->addServer($server->getHost(), $server->getPort(), $server->getWeight());
        // $this->servers[] = $server;
    }

    public function setNamespace($namespace)
    {
        $this->prefix = $namespace;
    }

    public function get($key)
    {
        $value = $this->pointer->get($this->prefix . $key);
        if ($value !== null) {
            return $value;
        }

        return false;
    }

    public function set($key, $value, $expire=0) // expire in seconds
    {
        $fullKey = $this->prefix . $key;
        $map = (array) $this->pointer->get('__cache_map');
        if (!in_array($fullKey, $map)) {
            $map[] = $fullKey;
            $this->pointer->set('__cache_map', $map, 0);
        }

        $this->pointer->set($fullKey, $value, $expire);
        return true;
    }

    public function delete($key)
    {
        $map = $this->pointer->get('__cache_map');
        unset($map[$this->prefix . $key]);
        $this->pointer->set('__cache_map', $map, 0);
        $this->pointer->delete($this->prefix . $key, 0);
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