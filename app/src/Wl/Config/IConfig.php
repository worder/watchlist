<?php

namespace Wl\Config;

interface IConfig
{
    public function has($key);
    public function get($key);
}