<?php

namespace Wl\Lists;

interface IList {
    public function getId(): ?int;
    public function getOwnerId(): ?int;
    public function getTitle(): string;
    public function getDesc(): string;
    public function getAdded(): string;
    public function getUpdated(): string;
}