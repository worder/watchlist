<?php

namespace Wl\Config\Provider;

interface IConfigProvider 
{
    public function hasParam($key);
    public function getParam($key);
}