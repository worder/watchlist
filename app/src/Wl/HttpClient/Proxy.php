<?php

namespace Wl\HttpClient;

class Proxy 
{
    const TYPE_HTTP = 'http';
    const TYPE_SOCKS4 = 'socks4';
    const TYPE_SOCKS5 = 'socks5';

    private $type;
    private $proxy;

    public function __construct($type, $proxy)
    {
        $this->checkType($type);
        $this->type = $type;
        $this->proxy = $proxy;
    }

    private function checkType($type)
    {
        if (!in_array($type, [self::TYPE_HTTP, self::TYPE_SOCKS4, self::TYPE_SOCKS5])) {
            throw new \Exception('Invalid proxy type: "' . $type . '"');
        }
    }

    public function getType()
    {
        return $this->type;
    }

    public function getProxy()
    {
        return $this->proxy;
    }

    public static function socks5($proxy)
    {
        return new self(self::TYPE_SOCKS5, $proxy);
    }

    // TODO rest of the types
}