<?php

declare(strict_types=1);

namespace App\Domain\Event;

use JsonSerializable;

abstract class Event implements JsonSerializable
{
    protected function __construct(public readonly array $payload)
    {
    }

    abstract public static function eventTypeName(): string;

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return $this->payload;
    }

    public static function occur(array $payload): static
    {
        return new static($payload);
    }
}