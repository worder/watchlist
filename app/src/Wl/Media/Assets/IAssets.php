<?php

namespace Wl\Media\Assets;

use Wl\Media\Assets\Poster\IPoster;

interface IAssets
{
    public function getPoster($size): ?IPoster;
}