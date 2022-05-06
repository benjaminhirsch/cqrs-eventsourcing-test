<?php

declare(strict_types=1);

namespace App\Domain\Command;

use Ramsey\Uuid\UuidInterface;

abstract class Command
{
    protected function __construct(protected readonly array $payload)
    {
    }

    public function aggregateRootId(): UuidInterface
    {
        return $this->payload['id'];
    }

    public static function fromArray(array $payload): static
    {
        return new static($payload);
    }
}