<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Aggregate\AggregateRoot;

interface AggregateRepository
{
    public function findBy(string $aggregateClassName, array $identifiers): AggregateRoot;
    public function addAggregateRoot(AggregateRoot $aggregateRoot): void;
}