<?php

namespace Wl\Media\MediaDetails;

use Wl\Media\IMediaLocalization;

class MovieDetails implements IMovieDetails
{
    private $runtimeMin = 0;
    
    public function __construct($runtimeMin)
    {
        $this->runtimeMin = $runtimeMin;
    }

    public function getRuntime()
    {
        return $this->runtimeMin;
    }
}