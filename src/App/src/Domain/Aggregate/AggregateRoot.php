<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use Ramsey\Uuid\UuidInterface;

abstract class AggregateRoot
{
    use WithAggregateEvents;

    public function __construct(public readonly UuidInterface $id)
    {
    }
}