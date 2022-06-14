<?php

namespace Wl\Lists;

interface IList {
    public function getId(): int;
    public function getTitle(): string;
    public function getDesc(): string;
}