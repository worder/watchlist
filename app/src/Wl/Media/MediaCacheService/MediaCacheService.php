<?php

namespace Wl\Media\MediaCacheService;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Db\Pdo\IManipulator;
use Wl\Media\ApiDataContainer\ApiDataContainer;
use Wl\Media\ApiDataContainer\IApiDataContainer;
use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\MediaLocale\IMediaLocaleRecord;
use Wl\Media\MediaLocale\MediaLocaleRecord;
use Wl\Utils\Date\Date;

class MediaCacheService implements IMediaCacheService
{
    /**
     * @Inject
     * @var IManipulator
     */
    private $db;

    /**
     * @Inject
     * @var ApiAdapterFactory
     */
    private $adapterFactory;

    public function isInCache($api, $mediaId, $locale): bool
    {
        $q = "SELECT 1 
                FROM media_cache 
               WHERE api=:api 
                     AND mediaId=:mediaId 
                     AND locale=:locale";

        return (bool) $this->db->getValue($q, ['api' => $api, 'mediaId' => $mediaId, 'locale' => $locale]);
    }

    public function getFromCache($api, $mediaId, $locale): ?IMediaLocaleRecord
    {
        $q = "SELECT * 
                FROM media_cache 
               WHERE api=:api 
                     AND mediaId=:mediaId 
                     AND locale=:locale";

        $row = $this->db->getRow($q, ['api' => $api, 'mediaId' => $mediaId, 'locale' => $locale]);

        if ($row) {
            $container = ApiDataContainer::import($row['data']);

            $localeRecord = new MediaLocaleRecord();
            $localeRecord->setAdded($row['added']);
            $localeRecord->setUpdated($row['updated']);

            $adapter = $this->adapterFactory->getAdapter($container->getApiId());
            return $adapter->buildMediaLocale($localeRecord, $container);
        }

        return null;
    }

    public function deleteFromCache($api, $mediaId, $locale): void
    {
    }

    public function addToCache(string $api, string $mediaId, string $locale, string $title, IApiDataContainer $data): void
    {
        $q = "INSERT INTO media_cache (api, mediaId, locale, data, title, added, updated)
                   VALUES (:api, :mediaId, :locale, :data, :title, :added, :updated)
                       ON DUPLICATE KEY 
                   UPDATE data=:data, title=:title, updated=:updated";

        $args['added'] = Date::now()->date();
        $this->db->exec($q, [
            'api' => $api, 
            'mediaId' => $mediaId,
            'locale' => $locale,
            'data' => $data->export(),
            'title' => $title,
            'added' =>  Date::now()->date(),
            'updated' => Date::now()->date()
        ]);
    }
}
