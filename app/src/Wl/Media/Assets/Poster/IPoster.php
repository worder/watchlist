<?php

namespace Wl\Media\Assets\Poster;

use Wl\Media\Assets\IAsset;

interface IPoster extends IAsset
{
    const SIZE_SMALL = 'SIZE_SMALL';
    const SIZE_MEDIUM = 'SIZE_MEDIUM';
    const SIZE_LARGE = 'SIZE_LARGE';
    const SIZE_ORIGINAL = 'SIZE_ORIGINAL';
}