<?php

namespace Wl\Lists\ListItems\ListItemStatus;

use Wl\Utils\Date\IDate;

interface IListItemStatus
{
    // inactive statuses
    const STATUS_STASHED = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_PLANNED = 2;
    const STATUS_DROPPED = 3;
    // active statuses
    const STATUS_DEFFERED = 10;
    const STATUS_NOMINATED = 11;
    const STATUS_IN_PROGRESS = 12;

        public function getId(): int;
    public function getItemId(): int;
    public function getUserId(): int;
    public function getDate(): IDate; // represents event date, may be retrospective, choosen by user in datepicker
    public function getAdded(): IDate;
    public function getType(): int;
    public function getValue(): string;
    
    public static function getAllTypes();
}