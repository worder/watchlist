<?php

namespace Wl\Media\Assets;

use Wl\Media\Assets\Poster\IPoster;

class Assets implements IAssets
{
    private $posters;

    public function getPoster($size): ?IPoster
    {
        if (isset($this->posters[$size])) {
            return $this->posters[$size];
        }

        return null;
    }

    public function addPoster(IPoster $poster, $size)
    {
        $this->posters[$size] = $poster;
    }
}
