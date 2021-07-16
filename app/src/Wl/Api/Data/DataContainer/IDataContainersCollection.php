<?php

namespace Wl\Api\Data\DataContainer;

interface IDataContainersCollection
{
    /**
     * @return IDataContainer[]
     */
    public function getContainers();
}