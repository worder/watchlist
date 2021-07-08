<?php

namespace Wl\Media;
interface IMediaLocalization
{
    public function getLocale();
    public function getLanguage();
    public function getTitle();
    public function getOverview();
}