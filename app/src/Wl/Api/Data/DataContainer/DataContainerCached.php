<?php
namespace Wl\Api\Data\DataContainer;

class DataContainerCached extends DataContainer implements IDataContainer
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

    public static function createFromContainer(IDataContainer $container) 
    {
        $cached = new self($container->getData(), $container->getApiId());
        $cached->setMetadata($container->getMetadata());
        return $cached;
    }
}