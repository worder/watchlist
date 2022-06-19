<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\DataAdapter\DataResolver;
use Wl\Api\DataAdapter\IDataAdapter;
use Wl\Media\DataContainer\IDataContainer;
use Wl\Media\IMedia;
use Wl\Media\IMediaLocale;
use Wl\Media\Media;
use Wl\Media\MediaLocale;

class ShikimoriAdapter implements IDataAdapter
{
    public function getMedia(IDataContainer $container): IMedia
    {
        $data = new DataResolver($container->getData());
        $media = new Media();

        $dict = ShikimoriTransport::MEDIA_TYPES_DICT;
        foreach ($dict as $wlType => $apiType) {
            if ($data->str('kind') === $apiType) {
                $media->setMediaType($wlType);
                break;
            }
        }

        $media->setApiMediaId($data->int('id'));
        $media->setReleaseDate($data->str('aired_on'));
        $media->setOriginalTitle($data->str('name'));

        return $media;
    }

    public function getMediaLocale(IDataContainer $container): IMediaLocale
    {
        $locale = new MediaLocale($container);
        $data = new DataResolver($container->getData());

        $locale->setTitle($data->str('russian'));
        
        return $locale;
    }
}