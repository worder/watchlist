<?php

namespace Wl\Config;

use Wl\Config\Exception\UnsetParamException;
use Wl\Config\Provider\IConfigProvider;

class ConfigService implements IConfig
{
    private $provider;

    public function __construct(IConfigProvider $provider)
    {
        $this->provider = $provider;
    }

    public function has($key)
    {
        return $this->provider->hasParam($key);
    }

    public function get($key)
    {
        if ($this->provider->hasParam($key)) {
            return $this->provider->getParam($key);
        } 

        throw new UnsetParamException('Param "' . $key . '" is not provided');
    }
}