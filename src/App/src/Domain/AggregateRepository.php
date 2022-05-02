<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Aggregator\AggregateRoot;

interface AggregateRepository
{
    public function findBy(string $aggregateClassName, array $identifiers): array;
    public function addAggregateRoot(AggregateRoot $aggregateRoot): void;
}