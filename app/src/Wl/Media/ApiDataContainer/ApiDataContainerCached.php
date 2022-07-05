<?php
namespace Wl\Media\ApiDataContainer;

class ApiDataContainerCached extends ApiDataContainer implements IApiDataContainer
{
    private $cacheExpirationTime;

    public function getCacheExpirationTime()
    {
        return $this->cacheExpirationTime;
    }

    public function setCacheExpirationTime($time)
    {
        return $this->cacheExpirationTime = $time;
    }

    public static function createFromContainer(IApiDataContainer $container) 
    {
        $cached = new self($container->getData(), $container->getApiId());
        $cached->setMetadata($container->getMetadata());
        return $cached;
    }
}