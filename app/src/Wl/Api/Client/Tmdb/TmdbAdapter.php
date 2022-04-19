<?php

namespace Wl\Api\Client\Tmdb;

use Wl\Api\Data\DataAdapter\DataResolver;
use Wl\Api\Data\DataAdapter\Exception\ApiMismatchException;
use Wl\Api\Data\DataAdapter\IDataAdapter;
use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Media\Details\MovieDetails;
use Wl\Media\Details\SeasonDetails;
use Wl\Media\Details\SeriesDetails;
use Wl\Media\IMedia;
use Wl\Media\Media;
use Wl\Media\MediaLocalization;
use Wl\Media\MediaType;

class TmdbAdapter implements IDataAdapter
{
    public function getMedia(IDataContainer $container): IMedia
    {
        if ($container->getApiId() !== TmdbTransport::API_ID) {
            throw new ApiMismatchException("\"{$container->getApiId()}\" container is not supported by TmdbAdapter");
        }

        $data = new DataResolver($container->getData());
        
        $media = new Media($container);
        
        $mediaType = $container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_MEDIA_TYPE);
        $requestLocale = $container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_REQUEST_LOCALE);

        if (!$mediaType) {
            throw new \Exception("Media type is missing");
        }

        // common features
        $media->setMediaId($data->int('id'));
        $media->setMediaType($mediaType);

        $media->setOriginalLocale($data->str('original_language'));
        $media->addLocalization(new MediaLocalization($data->str('original_language'), $data->str('original_title'), ''));
        $media->addLocalization(new MediaLocalization($requestLocale, $data->str('title'), $data->str('overview')));

        // var_dump($data);
        // type-specific features
        switch ($mediaType) {
            case MediaType::MOVIE:
                $media->setReleaseDate($data->str('release_date'));
                if ($data->has('runtime')) {
                    $movieDetails = new MovieDetails($data->str('runtime'));
                    $media->setDetails($movieDetails);
                }
                break;
            case MediaType::TV_SERIES:
                $media->setReleaseDate($data->str('first_air_date'));
                // details data only
                if ($data->has('number_of_seasons')) {
                    $seriesDetails = new SeriesDetails($data->str('number_of_seasons'));
                    $media->setDetails($seriesDetails);
                    for ($n = 1; $n <= $seriesDetails->getSeasonsNumber(); $n++) {
                        if ($data->arr('seasons')->has($n)) {
                            $sData = $data->arr('seasons')->arr($n);
                            $seasonDetails = new SeasonDetails($n, $sData->str('episode_count'));
                            $seasonDetails->addLocalization(
                                new MediaLocalization($requestLocale, $sData->str('name'), $sData->str('overview'))
                            );
                            $seriesDetails->addSeason($seasonDetails);
                        }
                    }
                }
                break;
        }

        return $media;
    }
}
