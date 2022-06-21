<?php

namespace Wl\Media;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\Details\IDetails;

class MediaLocale implements IMediaLocale
{
    private ?IMedia $media = null;
    private ?IDataContainer $container = null;

    private ?IDetails $details = null;
    private ?IAssets $assets = null;

    // private $api;
    private $locale = '';
    private $title = '';
    private $overview = '';

    public function __construct(?IDataContainer $dataContainer = null)
    {
        $this->container = $dataContainer;
    }

    // IMedia contains this already
    // public function getApi()
    // {
    //     return $this->api;
    // }
    // public function setApi($api)
    // {
    //     $this->api = $api;
    // }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview($overview): void
    {
        $this->overview = $overview;
    }

    public function getMedia(): ?IMedia
    {
        return $this->media;
    }

    public function setMedia(IMedia $media): void
    {
        $this->media = $media;
    }

    public function getDataContainer(): IDataContainer
    {
        return $this->container;
    }

    public function setDataContainer(IDataContainer $container): void
    {
        $this->container = $container;
    }

    public function getDetails(): ?IDetails
    {
        return $this->details;
    }

    public function setDetails(IDetails $details): void
    {
        $this->details = $details;
    }

    public function getAssets(): ?IAssets
    {
        return $this->assets;
    }

    public function setAssets(IAssets $assets): void
    {
        $this->assets = $assets;
    }
}
