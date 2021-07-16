<?php

namespace Wl\Api\Data\DataContainer;

interface IDataContainer
{
    public function getDatasourceType();
    public function getData();
    public function getCacheExpirationTime();
}