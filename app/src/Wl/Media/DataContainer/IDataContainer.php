<?php

namespace Wl\Media\DataContainer;

interface IDataContainer
{
    public function getApiId();
    public function getData();
    
    public function getMetadata();
    public function getMetadataParam($key);
    public function setMetadata(array $metadata);
    public function setMetadataParam($key, $value);

    public function export(): string;
    public static function import($data): IDataContainer;
}