<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

abstract class AggregateRoot
{
    use WithAggregateEvents;

    protected function __construct()
    {
    }
}