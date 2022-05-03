<?php

declare(strict_types=1);

namespace App\Domain\Event;

use Ramsey\Uuid\UuidInterface;

abstract class Event
{
    protected function __construct(private readonly UuidInterface $id, protected readonly array $payload)
    {
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public static function occur(UuidInterface $id, array $payload): static
    {
        return new static($id, $payload);
    }
}