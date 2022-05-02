<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Aggregator\AggregateRoot;

final class AggregateRepository implements \App\Domain\AggregateRepository
{
    private array $aggregates = [];

    /** Maybe this is not necessary, when all views / states are calculated at DB level
     * instead we could simply create an aggregate specific repo and query the
     * data with the current state?
     */
    public function findBy(string $aggregateClassName, array $identifiers): array
    {
        return $this->aggregates[$aggregateClassName] ?? [];
    }

    public function addAggregateRoot(AggregateRoot $aggregateRoot): void
    {
        $this->aggregates[get_class($aggregateRoot)][] = $aggregateRoot;
    }
}