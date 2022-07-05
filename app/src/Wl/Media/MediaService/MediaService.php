<?php

namespace Wl\Media\MediaService;

use Wl\Api\Factory\ApiAdapterFactory;
use Wl\Db\Pdo\IManipulator;
use Wl\Media\ApiDataContainer\ApiDataContainer;
use Wl\Media\IMedia;
use Wl\Media\MediaLocale\IMediaLocale;
use Wl\Media\MediaLocale\IMediaLocaleRecord;
use Wl\Media\MediaLocale\MediaLocaleRecord;
use Wl\Media\IMediaRecord;
use Wl\Media\MediaRecord;

use function PHPSTORM_META\map;

class MediaService implements IMediaService
{
    private $db;

    public function __construct(IManipulator $db)
    {
        $this->db = $db;
    }

    public function addMedia(IMedia $media): IMediaRecord
    {
        $apiMediaId = $media->getApiMediaId();
        $api = $media->getApi();

        if (empty($apiMediaId) || empty($api)) {
            throw new MediaServiceException('Invalid data');
        }

        $exists = $this->getMediaByApiId($api, $apiMediaId);
        if ($exists) {
            throw new MediaServiceException('Media already exists, ID:' . $exists->getId());
        }

        $q = "INSERT INTO media (`apiMediaId`, `type`, `api`, `originalTitle`, 
                                 `originalLocale`, `releaseDate`, `added`, `updated`) 
                   VALUES (:apiMediaId, :type, :api, :originalTitle, 
                           :originalLocale, :releaseDate, NOW(), NOW())";

        $result = $this->db->exec($q, [
            'apiMediaId' => $apiMediaId,
            'api' => $api,
            'type' => $media->getMediaType(),
            'originalTitle' => $media->getOriginalTitle(),
            'originalLocale' => $media->getOriginalLocale(),
            'releaseDate' => $media->getReleaseDate(),
        ]);

        if ($result->getId()) {
            return $this->getMediaById($result->getId());
        }
    }

    public function addMediaLocale(IMediaLocale $locale): IMediaLocaleRecord
    {
        // `id` int(11) PRIMARY KEY AUTO_INCREMENT,
        // `mediaId` int(11) NOT NULL,
        // `locale` varchar(10) NOT NULL,
        // `data` MEDIUMTEXT NOT NULL,
        // `title` varchar(1024) NOT NULL,
        // `added` datetime NOT NULL,
        // `updated` datetime NOT NULL,

        $media = $locale->getMedia();
        $mediaRecord = $this->getMediaByApiId($media->getApi(), $media->getApiMediaId());
        if (!$mediaRecord) {
            $mediaRecord = $this->addMedia($media);
        }

        $mediaId = $mediaRecord->getId();
        $localeCode = $locale->getLocale();
        $data = $locale->getDataContainer()->export();
        $title = $locale->getTitle();

        $q = "INSERT INTO media_locale (`mediaId`, `locale`, `data`, `title`, `added`, `updated`) 
                   VALUES (:mediaId, :locale, :data, :title, NOW(), NOW())";
        $result = $this->db->exec($q, [
            'mediaId' => $mediaId,
            'locale' => $localeCode,
            'data' => $data,
            'title' => $title
        ]);

        if ($result->getId()) {
            return $this->getMediaLocaleById($result->getId());
        }
    }

    public function getMediaById($id): IMediaRecord
    {
        $q = "SELECT * FROM media WHERE id=:id";
        $row = $this->db->getRow($q, ['id' => $id]);
        if ($row) {
            return $this->buildMediaRecord($row);
        }

        throw new MediaServiceException('Media not found, ID:' . $id);
    }

    public function getMediaByApiId($api, $apiMediaId): ?IMediaRecord
    {
        $q = "SELECT * FROM media WHERE api=:api AND apiMediaId=:id";

        $row = $this->db->getRow($q, ['api' => $api, 'id' => $apiMediaId]);
        if (!empty($row)) {
            return $this->buildMediaRecord($row);
        }

        return null;
    }

    public function getMediaLocaleById($id): IMediaLocaleRecord
    {
        $q = "SELECT ml.*, 
                     m.id AS m_id,
                     m.added AS m_added,
                     m.updated AS m_updated,
                     m.api AS m_api
                FROM media_locale ml 
          RIGHT JOIN media m
               WHERE id=:id";
        $row = $this->db->getRow($q, ['id' => $id]);
        if ($row) {
            return $this->buildMediaLocale($row, '_m');
        }

        throw new MediaServiceException('Media locale not found, ID:' . $id);
    }

    private function buildMediaRecord($data, $fieldPrefix = ''): IMediaRecord
    {
        $media = new MediaRecord();
        $media->setId($data[$fieldPrefix . 'id']);
        $media->setApi($data[$fieldPrefix . 'api']);
        $media->setAdded($data[$fieldPrefix . 'added']);
        $media->setUpdated(($data[$fieldPrefix . 'updated']));

        // sould be extraceted from container
        // isset($data[$fieldPrefix . 'apiMediaId']) && $media->setApiMediaId($data[$fieldPrefix . 'apiMediaId']);
        // isset($data[$fieldPrefix . 'type']) && $media->setMediaType($data[$fieldPrefix . 'type']);
        // isset($data[$fieldPrefix . 'originalLocale']) && $media->setOriginalLocale($data[$fieldPrefix . 'originalLocale']);
        // isset($data[$fieldPrefix . 'originalTitle']) && $media->setOriginalTitle($data[$fieldPrefix . 'originalTitle']);
        // isset($data[$fieldPrefix . 'releaseDate']) && $media->setReleaseDate($data[$fieldPrefix . 'releaseDate']);

        return $media;
    }

    private function buildMediaLocale($data, $mediaRecordPrefix): IMediaLocaleRecord
    {
        $mediaRecord = $this->buildMediaRecord($data, $mediaRecordPrefix);

        $locale = new MediaLocaleRecord(ApiDataContainer::import($data['data']));
        $locale->setMedia($mediaRecord);
        $locale->setAdded($data['added']);
        $locale->setUpdated($data['updated']);

        return $locale;
    }
}
