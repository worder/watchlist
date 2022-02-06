<?php

namespace Wl\Api\Data\DataContainer;

use Wl\Api\Data\DataContainer\IDataContainer;

class DataContainer implements IDataContainer
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
}