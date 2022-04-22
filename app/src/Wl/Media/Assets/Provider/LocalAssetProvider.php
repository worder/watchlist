<?php

namespace Wl\Media\Assets\Provider;

use Wl\Media\Assets\IAsset;

class HttpProxiedAssetProvider implements IAsset
{
    private $id;

    public function __construct($assetId)
    {
        $this->id = $assetId;
    }

    public function getUrl(): string
    {
        return '/api/asset/local/' . $this->id;
    }
}