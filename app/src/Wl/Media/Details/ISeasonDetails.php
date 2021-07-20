<?php

namespace Wl\Media\Details;

use Wl\Media\IMediaLocalization;

interface ISeasonDetails extends IDetails
{
    public function getSeasonNumber();
    public function getEpisodesNumber();
    public function getLocalization($locale): ?IMediaLocalization;
}