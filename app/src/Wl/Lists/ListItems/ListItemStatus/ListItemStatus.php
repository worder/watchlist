<?php

namespace Wl\Lists\ListItems\ListItemStatus;

use Wl\Utils\Date\Date;
use Wl\Utils\Date\IDate;

class ListItemsStatus implements IListItemStatus
{
    private $id;
    private $itemId;
    private $userId;
    private $date;
    private $added;
    private $type;
    private $value;

    public function __construct($type, $itemId, $userId, $value = null, $date = null)
    {
        $this->type = $type;
        $this->userid = $userId;
        $this->itemId = $itemId;
        $this->value = $value;
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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
        
        return Date::fromDate($this->date);
    }

    public function getAdded(): IDate
    {
        return Date::fromDate($this->added);
    }

    public function setAdded(string $added)
    {
        $this->added = $added;
    }


    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}