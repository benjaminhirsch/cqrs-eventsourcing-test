<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Model\Building;

interface BuildingRepository extends AggregateRepository
{
    public function getBuilding(string $aggregateRootId): ?Building;

    /**
     * @return Building[]
     */
    public function getAllBuilding(): array;
}