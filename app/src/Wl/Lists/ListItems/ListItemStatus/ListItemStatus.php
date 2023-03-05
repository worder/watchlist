<?php

namespace Wl\Lists\ListItems\ListItemStatus;

use Wl\Utils\Date\Date;
use Wl\Utils\Date\IDate;

class ListItemStatus implements IListItemStatus
{
    static $statusMnemonics = [
        self::STATUS_STASHED => 'STATUS_STASHED',
        self::STATUS_COMPLETED => 'STATUS_COMPLETED',
        self::STATUS_PLANNED => 'STATUS_PLANNED',
        self::STATUS_DROPPED => 'STATUS_DROPPED',
        self::STATUS_DEFFERED => 'STATUS_DEFFERED',
        self::STATUS_NOMINATED => 'STATUS_NOMINATED',
        self::STATUS_IN_PROGRESS => 'STATUS_IN_PROGRESS',
    ];

    private $id;
    private $itemId;
    private $userId;
    private $date;
    private $added;
    private $type;
    private $value;

    public function __construct(int $id, int $type, int $itemId, int $userId, $value = null, ?IDate $added, ?IDate $date = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->value = $value;
        $this->date = $date;
        $this->added = $added;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getItemId(): int
    {
        return $this->itemId;
    }


    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getDate(): IDate
    {
        if (!$this->date) {
            return Date::now();
        }

        return $this->date;
    }

    public function getAdded(): IDate
    {
        return $this->added;
    }


    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function getAllTypes()
    {
        return [
            IListItemStatus::STATUS_COMPLETED,
            IListItemStatus::STATUS_DEFFERED,
            IListItemStatus::STATUS_DROPPED,
            IListItemStatus::STATUS_IN_PROGRESS,
            IListItemStatus::STATUS_NOMINATED,
            IListItemStatus::STATUS_PLANNED,
            IListItemStatus::STATUS_STASHED
        ];
    }
}
