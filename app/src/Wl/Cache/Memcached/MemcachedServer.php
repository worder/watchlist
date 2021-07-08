<?php

namespace Wl\Cache\Memcached;

class MemcachedServer
{
    private $host;
    private $port;
    private $weight;

    public function __construct($host, $port = 11211, $weight = 0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->weight = $weight;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getWeight()
    {
        return $this->weight;
    }
}