<?php

namespace Wl\Media\Assets;

use Wl\Media\Assets\Poster\IPoster;

interface IMediaAssets
{
    public function getPoster($size): IPoster;
}