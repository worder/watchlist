<?php

namespace Wl\Media\Assets\Poster;

use Wl\Media\Assets\IAsset;

interface IPoster extends IAsset
{
    const SIZE_SMALL = 's';
    const SIZE_MEDIUM = 'm';
    const SIZE_LARGE = 'l';
    const SIZE_ORIGINAL = 'o';

    public function getSize(): string;
}