<?php

namespace Wl\Api\Data\DataContainer;

interface IDataContainer
{
    public function getDatasourceType();
    public function getData();
    public function getCacheExpirationTime();
    
    public function getMetadata();
    public function getMetadataParam($key);
    public function setMetadata(array $metadata);
    public function setMetadataParam($key, $value);
}