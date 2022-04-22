<?php

namespace Wl\Media\Assets\Provider;

use Wl\Media\Assets\IAsset;

class HttpProxiedAssetProvider implements IAsset
{
    private $externalUrl;
    private $apiId;

    public function __construct($externalUrl, $apiId)
    {
        $this->externalUrl = $externalUrl;
        $this->apiId = $apiId;
    }

    public function getUrl(): string
    {
        $data = json_encode([$this->externalUrl, $this->apiId]);
        return '/api/asset/proxy/' . urlencode(base64_encode($data));
    }
}
