<?php

namespace Wl\Api\Client\Tmdb;

use Wl\Api\Data\DataAdapter\Exception\ApiMismatchException;
use Wl\Api\Data\DataAdapter\Exception\InvalidDatasourceException;
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

        $media = new Media($container);

        $data = $container->getData();
        $mediaType = $container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_MEDIA_TYPE);
        $requestLocale = $container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_REQUEST_LOCALE);

        // common features
        $media->setMediaId($data['id']);
        $media->setMediaType($mediaType);


        $media->setOriginalLocale($data['original_language']);
        $media->addLocalization(new MediaLocalization($data['original_language'], $data['original_name'], ''));
        $media->addLocalization(new MediaLocalization($requestLocale, $data['name'], $data['overview']));


        // type-specific features
        switch ($mediaType) {
            case MediaType::MOVIE:
                $media->setReleaseDate($data['release_date']);
                $movieDetails = new MovieDetails($data['runtime']);
                $media->setDetails($movieDetails);
                break;
            case MediaType::TV_SERIES:
                $media->setReleaseDate($data['first_air_date']);
                // details data only
                if (isset($data['number_of_seasons'])) {
                    $seriesDetails = new SeriesDetails($data['number_of_seasons']);
                    $media->setDetails($seriesDetails);
                    for ($n = 1; $n <= $seriesDetails->getSeasonsNumber(); $n++) {
                        if (isset($data['seasons'][$n])) {
                            $sData = $data['seasons'][$n];
                            $seasonDetails = new SeasonDetails($n, $sData['episode_count']);
                            $seasonDetails->addLocalization(new MediaLocalization($requestLocale, $sData['name'], $sData['overview']));
                            $seriesDetails->addSeason($seasonDetails);
                        }
                    }
                }
                break;
        }

        return $media;
    }
}
