<?php

namespace Wl\Lists\ListItems\ListItemFeature;

interface IListItemFeatures
{
    /**
     * @return IListItemFeatures[]
     */
    public function getAll(): array;
    public function getFeaturesByType($type): IListItemFeature;
}