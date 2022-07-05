<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\DataAdapter\DataResolver;
use Wl\Api\DataAdapter\IDataAdapter;
use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Media\IMedia;
use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\Media;
use Wl\Media\MediaLocale\MediaLocale;

class ShikimoriAdapter implements IDataAdapter
{
    public function buildMedia(IMedia $media, IApiDataContainer $container): IMedia
    {
        // $data = new DataResolver($container->getData());
        // $media = new Media();

        // $dict = ShikimoriTransport::MEDIA_TYPES_DICT;
        // foreach ($dict as $wlType => $apiType) {
        //     if ($data->str('kind') === $apiType) {
        //         $media->setMediaType($wlType);
        //         break;
        //     }
        // }

        // $media->setApiMediaId($data->int('id'));
        // $media->setOriginalTitle($data->str('name'));
        // if ($data->has('aired_on')) {
        //     $media->setReleaseDate($data->str('aired_on'));
        // }

        return $media;
    }

    public function buildMediaLocale(IMediaLocale $locale, IApiDataContainer $container): IMediaLocale
    {
        $locale->setDataContainer($container);
        
        $media = $locale->getMedia() ?? new Media();
        $this->buildMedia($media, $container);
        $locale->setMedia($media);
        
        $data = new DataResolver($container->getData());
        $locale->setTitle($data->str('russian'));

        return $locale;
    }
}
