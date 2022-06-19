<?php

namespace Wl\Media;

use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\Assets\IAssets;
use Wl\Media\Details\IDetails;

class MediaLocale implements IMediaLocale
{
    private ?IMedia $media;
    private ?IDataContainer $container;

    private ?IDetails $details;
    private ?IAssets $assets;

    private $id;
    private $locale;
    private $title;
    private $overview;

    public function __construct(?IDataContainer $dataContainer)
    {
        $this->container = $dataContainer;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getOverview()
    {
        return $this->overview;
    }

    public function setOverview($overview)
    {
        $this->overview = $overview;
    }

    public function getMedia(): IMedia
    {
        return $this->media;
    }

    public function setMedia(IMedia $media)
    {
        $this->media = $media;
    }

    public function getDataContainer(): IDataContainer
    {
        return $this->container;
    }

    public function setDataContainer(IDataContainer $container)
    {
        $this->container = $container;
    }

    public function getDetails(): ?IDetails
    {
        return $this->details;
    }

    public function setDetails(IDetails $details)
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
