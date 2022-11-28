<?php

namespace Wl\Api\Client\Tmdb;

use Wl\Api\DataAdapter\DataResolver;
use Wl\Api\DataAdapter\Exception\ApiMismatchException;
use Wl\Api\DataAdapter\IDataAdapter;
use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Media\Assets\Assets;
use Wl\Media\Assets\Poster\IPoster;
use Wl\Media\Assets\Poster\Poster;
use Wl\Media\Assets\Provider\HttpProxiedAssetProvider;
use Wl\Media\MediaDetails\MovieDetails;
use Wl\Media\MediaDetails\SeasonDetails;
use Wl\Media\MediaDetails\SeriesDetails;
use Wl\Media\IMedia;
use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\Media;
use Wl\Media\MediaLocale\MediaLocale;
use Wl\Media\MediaType;
use Wl\Mvc\Result\ApiResult;
use Wl\Utils\Path;

class TmdbAdapter implements IDataAdapter
{
    public function buildMedia(IMedia $media, IApiDataContainer $container): IMedia
    {
        $data = new DataResolver($container->getData());

        $media->setApiMediaId((string) $data->int('id'));
        $media->setMediaType($container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_MEDIA_TYPE));
        $media->setOriginalLocale($data->str('original_language'));

        if ($data->has('original_title')) {
            $media->setOriginalTitle($data->str('original_title'));
        } elseif ($data->has('original_name')) {
            $media->setOriginalTitle($data->str('original_name'));
        }

        if ($data->has('release_date')) {
            $media->setReleaseDate($data->str('release_date'));
        } elseif ($data->has('first_air_date')) {
            $media->setReleaseDate($data->str('first_air_date'));
        }

        return $media;
    }

    public function buildMediaLocale(IMediaLocale $locale, IApiDataContainer $container): IMediaLocale
    {
        if ($container->getApiId() !== TmdbTransport::API_ID) {
            throw new ApiMismatchException("\"{$container->getApiId()}\" container is not supported by TmdbAdapter");
        }

        $media = $locale->getMedia() ?? new Media();
        $this->buildMedia($media, $container);
        $locale->setMedia($media);

        $data = new DataResolver($container->getData());
        $locale->setDataContainer($container);

        $locale->setLocale($container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_REQUEST_LOCALE));

        if ($data->has('title')) {
            $locale->setTitle($data->str('title'));
        } else {
            $locale->setTitle($data->str('name'));
        }

        $locale->setOverview($data->str('overview'));

        // ---

        $mediaType = $container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_MEDIA_TYPE);

        if (!$mediaType) {
            throw new \Exception("Media type is missing");
        }

        // var_dump($data);

        // assets
        $conf = new DataResolver($container->getMetadataParam(TmdbTransport::CONTAINER_META_PARAM_CONFIG));
        $assets = new Assets();
        if ($data->has('poster_path')) {
            $assetsBaseUrl = $conf->str('secureBaseUrl');
            $posterSizes = $conf->getArray('posterSizes');
            $sizeMap = [
                IPoster::SIZE_SMALL => 'w92',
                IPoster::SIZE_MEDIUM => 'w342',
                IPoster::SIZE_LARGE => 'w780',
                IPoster::SIZE_ORIGINAL => 'original'
            ];
            foreach ($sizeMap as $size => $apiSizeConst) {
                if (!in_array($apiSizeConst, $posterSizes)) {
                    throw new \Exception('Invalid poster size: ' . $apiSizeConst);
                }
                $posterUrl = $assetsBaseUrl . Path::join($apiSizeConst, $data->str('poster_path'));
                $posterProvider = new HttpProxiedAssetProvider($posterUrl, TmdbTransport::API_ID);
                $assets->addPoster(new Poster($posterProvider, $size), $size);
            }
        }
        $locale->setAssets($assets);

        // type-specific features
        switch ($mediaType) {
            case MediaType::MOVIE:
                if ($data->has('runtime')) {
                    $movieDetails = new MovieDetails($data->str('runtime'));
                    $locale->setDetails($movieDetails);
                }
                break;
            case MediaType::TV_SERIES:
                if ($data->has('number_of_seasons')) {
                    $seriesDetails = new SeriesDetails($data->int('number_of_seasons'));
                    $locale->setDetails($seriesDetails);
                    for ($n = 1; $n <= $seriesDetails->getSeasonsNumber(); $n++) {
                        if ($data->arr('seasons')->has($n)) {
                            $sData = $data->arr('seasons')->arr($n);
                            $seasonDetails = new SeasonDetails($n, $sData->int('episode_count'));
                            $seasonDetails->setTitle($sData->str('name'));
                            $seasonDetails->setOverview($sData->str('overview'));
                            $seriesDetails->addSeason($seasonDetails);
                        }
                    }
                }
                break;
        }

        return $locale;
    }
}
