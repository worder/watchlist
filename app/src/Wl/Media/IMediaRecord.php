<?php

namespace Wl\Media;

interface IMediaRecord extends IMedia
{
    public function getId(): ?int;
    public function setId(int $id): void;

    public function getAdded(): string;
    public function setAdded(string $date);

    public function getUpdated(): string;
    public function setUpdated(string $date);
}