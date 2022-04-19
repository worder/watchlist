<?php

namespace Wl\Api\Data\DataAdapter;

use Wl\Api\Data\DataAdapter\Exception\DataResolverException;

class DataResolver
{
    private $data;
    private $hierarchy;

    public function __construct($data, $hierarchy = [])
    {
        $this->data = $data;
        $this->hierarchy = $hierarchy;
    }

    private function assertRequired($key)
    {
        if (!$this->has($key)) {
            $hierarchy = implode('.', $this->hierarchy);
            throw new DataResolverException("Trying to access non existent key: \"{$key}\" in \"{$hierarchy}\"");
        }
    }

    public function arr($key)
    {
        $this->assertRequired($key);
        return new self($this->data[$key], array_merge($this->hierarchy, [$key]));
    }

    public function str($key, $required = true)
    {
        if ($required) {
            $this->assertRequired($key);
        }

        if (is_string($this->data[$key])) {
            return $this->data[$key];
        }

        $hierarchy = implode('.', array_merge($this->hierarchy, [$key]));
        throw new DataResolverException("Type mismatch at '{$hierarchy}', expected: string, got: " . gettype($this->data[$key]));
    }

    public function int($key, $required = true)
    {
        if ($required) {
            $this->assertRequired($key);
        }

        if (is_integer($this->data[$key])) {
            return $this->data[$key];
        }

        $hierarchy = implode('.', array_merge($this->hierarchy, [$key]));
        throw new DataResolverException("Type mismatch at '{$hierarchy}', expected: int, got: " . gettype($this->data[$key]));
    }

    public function has($key)
    {
        return is_array($this->data) && isset($this->data[$key]);
    }
}
