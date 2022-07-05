<?php

namespace Wl\Media\ApiDataContainer;

interface IApiDataContainersCollection
{
    /**
     * @return IApiDataContainer[]
     */
    public function getContainers();
}