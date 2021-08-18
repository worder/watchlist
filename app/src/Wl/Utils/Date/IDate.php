<?php

namespace Wl\Utils\Date;

interface IDate
{
    public function timestamp(): int;
    public function date(): string;
    
    public function plusMinutes(int $number): IDate;
    public function plusHours(int $number): IDate;
    public function plusDays(int $number): IDate;
    public function plusMonths(int $number): IDate;
}