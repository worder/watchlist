<?php

namespace Wl\Media\ApiDataContainer;

use Wl\Media\ApiDataContainer\IApiDataContainer;

class ApiDataContainer implements IApiDataContainer
{
    private $data;
    private $apiId;
    private $metadata = [];

    public function __construct($data, $apiId)
    {
        $this->data = $data;
        $this->apiId = $apiId;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getApiId()
    {
        return $this->apiId;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata(array $meta)
    {
        $this->metadata = $meta;
    }

    public function setMetadataParam($key, $value)
    {
        $this->metadata[$key] = $value;
    }

    public function getMetadataParam($key) 
    {
        return $this->metadata[$key] ?: null;
    }

    public function export(): string
    {
        return json_encode([$this->data, $this->apiId, $this->metadata]);
    }

    public static function import(string $data): IApiDataContainer
    {
        $decoded = json_decode($data, true);
        $container = new self($decoded[0], $decoded[1]);
        $container->setMetadata($decoded[2]);
        return $container;
    }
}