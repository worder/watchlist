<?php

namespace Wl\Media\Assets\Provider;

use Wl\Media\Assets\IAsset;

class ExternalAssetProvider implements IAsset
{
    private $url;

    public function __construct($externalUrl)
    {
        $this->url = $externalUrl;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}