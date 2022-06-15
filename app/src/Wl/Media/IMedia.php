<?php

namespace Wl\Media;

interface IMedia
{
    public function getId();
    public function getMediaId();
    public function getApi();

    public function getLocale($locale): IMediaLocale;
    public function hasLocale($locale);
}