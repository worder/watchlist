<?php

namespace Wl\Api\Data\DataContainer;

use Wl\Api\Data\DataContainer\IDataContainer;

class DataContainer implements IDataContainer
{
    private $data;
    private $datasourceType;
    private $cacheExpirationTime;

    public function __construct($data, $datasourceType)
    {
        $this->data = $data;
        $this->datasourceType = $datasourceType;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getDatasourceType()
    {
        return $this->datasourceType;
    }

    public function getCacheExpirationTime()
    {
        return $this->cacheExpirationTime;
    }

    public function setCacheExpirationTime($time)
    {
        return $this->cacheExpirationTime = $time;
    }
}