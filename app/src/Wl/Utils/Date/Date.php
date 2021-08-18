<?php

namespace Wl\Utils\Date;

class Date implements IDate
{
    private $time;
    
    const DATETIME_FORMAT = "Y-m-d H:i:s";

    private function __construct($timestamp)
    {
        $this->time = $timestamp;
    }

    static function fromTimestamp($timestamp)
    {
        return new self($timestamp);
    }

    static function fromDate($date)
    {
         return new self(strtotime($date));
    }

    static function now()
    {
        return new self(time());
    }



    public function timestamp(): int
    {
        return $this->time;
    }

    public function date(): string
    {
        return date(self::DATETIME_FORMAT, $this->time);
    }

    public function plusHours(int $number): IDate
    {
        return new self(strtotime("+{$number} hour", $this->time));
    }

    public function plusMinutes(int $number): IDate
    {
        return new self(strtotime("+{$number} minute", $this->time));
    }

    public function plusDays(int $number): IDate
    {
        return new self(strtotime("+{$number} day", $this->time));
    }

    public function plusMonths(int $number): IDate
    {
        return new self(strtotime("+{$number} month", $this->time));
    }
}