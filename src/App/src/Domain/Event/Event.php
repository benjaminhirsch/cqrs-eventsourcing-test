<?php

declare(strict_types=1);

namespace App\Domain\Event;

abstract class Event
{
    protected function __construct(public readonly array $payload)
    {
    }

    abstract public static function eventTypeName(): string;

    public static function occur(array $payload): static
    {
        return new static($payload);
    }
}