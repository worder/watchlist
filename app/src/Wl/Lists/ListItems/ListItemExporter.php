<?php

namespace Wl\Lists\ListItems;

use Wl\Media\Assets\Poster\IPoster;

class ListItemExporter 
{
    public static function export(IListItem $item) 
    {
        $locale = $item->getMediaLocale();
        $media = $locale->getMedia();
        $status = $item->getCurrentStatus();

        $assets = $locale->getAssets();

        return [
            'id' => $item->getId(),
            'api' => $media->getApi(),
            'mediaId' => $media->getApiMediaId(),
            'type' => $media->getMediaType(),
            'release_date' => $media->getReleaseDate(),
            'original_title' => $media->getOriginalTitle(),
            'title' => $locale->getTitle(),
            'posters' => [
                's' => $assets->getPoster(IPoster::SIZE_SMALL)->getUrl(),
                'm' => $assets->getPoster(IPoster::SIZE_MEDIUM)->getUrl(),
                'l' => $assets->getPoster(IPoster::SIZE_LARGE)->getUrl(),
            ],
        ];
    }
};