<?php

namespace Wl\Api\Client\Shikimori;

use Wl\Api\Data\DataAdapter\IDataAdapter;
use Wl\Api\Data\DataContainer\IDataContainer;
use Wl\Media\IMedia;
use Wl\Media\Media;
use Wl\Media\MediaLocalization;

class ShikimoriAdapter implements IDataAdapter
{
    public function getMedia(IDataContainer $container): IMedia
    {
        $data = $container->getData();

        $item = new Media($container);

        $dict = ShikimoriTransport::MEDIA_TYPES_DICT;
        foreach ($dict as $wlType => $apiType) {
            if ($data['kind'] === $apiType) {
                $item->setMediaType($wlType);
                break;
            }
        }

        $item->addLocalization(new MediaLocalization('ru', $data['russian']));
        $item->addLocalization(new MediaLocalization('en', $data['name']));

        $item->setMediaId($data['id']);
        $item->setReleaseDate($data['aired_on']);

        return $item;
    }
}