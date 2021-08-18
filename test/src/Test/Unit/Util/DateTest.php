<?php

namespace Test\Unit\Util;

use PHPUnit\Framework\TestCase;
use Wl\Utils\Date\Date;

class DateTest extends TestCase
{
    public function testSomething(): void
    {
        $timestamp = time();
        $timestampDate = date(Date::DATETIME_FORMAT, $timestamp);

        $futureVal = 10;
        $futureMins = strtotime("+{$futureVal} minute", $timestamp);
        $futureHours = strtotime("+{$futureVal} hour", $timestamp);
        $futureDays = strtotime("+{$futureVal} day", $timestamp);
        $futureMonths = strtotime("+{$futureVal} month", $timestamp);

        $subjects = [
            "timestamp" => Date::fromTimestamp($timestamp),
            "date" => Date::fromDate($timestampDate),
        ];

        foreach ($subjects as $source => $obj) {
            $this->assertSame($timestampDate, $obj->date(), "Check date string (from ${source})");
            $this->assertSame($timestamp, $obj->timestamp(), "Check timestamp (from ${source})");

            $this->assertSame($futureMins, $obj->plusMinutes($futureVal)->timestamp(), "Check future minutes (from ${source})");
            $this->assertSame($futureHours, $obj->plusHours($futureVal)->timestamp(), "Check future months (from ${source})");
            $this->assertSame($futureDays, $obj->plusDays($futureVal)->timestamp(), "Check future days (from ${source})");
            $this->assertSame($futureMonths, $obj->plusMonths($futureVal)->timestamp(), "Check future months (from ${source})");
        }
    }
}
