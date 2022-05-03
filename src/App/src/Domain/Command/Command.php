<?php

declare(strict_types=1);

namespace App\Domain\Command;

abstract class Command
{
    private function __construct(protected readonly array $payload)
    {
    }

    public static function fromArray(array $payload): static
    {
        return new static($payload);
    }
}