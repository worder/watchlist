<?php

namespace Wl\Lists\ListItems\ListItemFeature;

use Wl\Utils\Date\IDate;

interface IListItemFeature 
{
    public function getId(): int;
    public function getItemId(): int;
    public function getUserId(): int;
    public function getType(): int;
    public function getValue(): string;
    public function getAdded(): IDate;
}