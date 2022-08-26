<?php

namespace App\Services;

class MemoryService
{
    private array $data = [];

    public function put($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        return $this->data[$key] ?? null;
    }

    public function dump(): array
    {
        return $this->data;
    }
}
