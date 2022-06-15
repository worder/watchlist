<?php

namespace Wl\Media\DataContainer;

interface IDataContainersCollection
{
    /**
     * @return IDataContainer[]
     */
    public function getContainers();
}