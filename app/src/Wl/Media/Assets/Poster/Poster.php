<?php

namespace Wl\Media\Assets\Poster;

use Wl\Media\Assets\IAsset;

class Poster implements IPoster, IAsset
{
    private string $size;
    private IAsset $provider;

    public function __construct(IAsset $provider, $size)
    {
        $this->size = $size;
        $this->provider = $provider;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getUrl(): string
    {
        return $this->provider->getUrl();
    }
}