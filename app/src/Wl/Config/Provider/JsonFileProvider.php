<?php

namespace Wl\Config\Provider;

use Wl\Config\Provider\Exception\ProviderException;

class JsonFileProvider implements IConfigProvider
{
    private $data;

    public function __construct($jsonFilePath)
    {
        if (!file_exists($jsonFilePath)) {
            $this->error("file \"{$jsonFilePath}\" does not exists");
        }

        $json = file_get_contents($jsonFilePath);
        $this->data = json_decode($json, true);
    }

    public function hasParam($key)
    {
        return isset($this->data[$key]);
    }

    public function getParam($key)
    {
        if ($this->hasParam($key)) {
            return $this->data[$key];
        }

        $this->error("param \"{$key}\" does not exists");
    }

    private function error($msg)
    {
        throw new ProviderException("JsonFileProvider error: " . $msg);
    }
}