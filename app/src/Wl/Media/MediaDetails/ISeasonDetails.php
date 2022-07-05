<?php

namespace Wl\Media\MediaDetails;

use Wl\Media\IMediaLocalization;

interface ISeasonDetails extends IMediaDetails
{
    public function getSeasonNumber();
    public function getEpisodesNumber();

    public function getTitle();
    public function getOverview();
}