<?php

namespace Wl\Media\MediaCacheService;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Db\Pdo\IManipulator;
use Wl\Media\ApiDataContainer\ApiDataContainer;
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
            $container = new ApiDataContainer($row['data'], $row['api']);

            $localeRecord = new MediaLocaleRecord();
            $localeRecord->setAdded($row['added']);
            $localeRecord->setUpdated($row['updated']);

            $adapter = $this->adapterFactory->getAdapter($row['api']);
            return $adapter->buildMediaLocale($localeRecord, $container);
        }

        return null;
    }

    public function deleteFromCache($api, $mediaId, $locale): void
    {
    }

    public function addToCache(string $api, string $mediaId, string $locale, string $title, $data): void
    {
        if (!$this->isInCache($api, $mediaId, $locale)) {
            $q = "INSERT INTO media_cache (api, mediaId, locale, data, title, added, updated)
                   VALUEs (:api, :mediaId, :locale, :data, :title, :added, :updated)";
    
            $args['added'] = Date::now()->date();
            $this->db->exec($q, [
                'api' => $api, 
                'mediaId' => $mediaId,
                'locale' => $locale,
                'data' => json_encode($data),
                'title' => $title,
                'added' =>  Date::now()->date(),
                'updated' => Date::now()->date()
            ]);
        } else {
            $q = "UPDATE media_cache SET data=:data, title=:title, updated=:updated";
            $this->db->exec($q, [
                'data' => json_encode($data),
                'title' => $title,
                'updated' => Date::now()->date()
            ]);
        }
    }
}
