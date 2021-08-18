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

    public function timestamp()
    {
        return $this->time;
    }

    public function date()
    {
        return date(self::DATETIME_FORMAT, $this->time);
    }
}