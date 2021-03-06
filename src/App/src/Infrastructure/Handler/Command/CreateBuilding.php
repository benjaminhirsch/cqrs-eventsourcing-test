<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Command;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\BuildingRepository;
use App\Domain\Command\Command;
use App\Domain\Command\CreateBuilding as CreateBuildingCommand;
use App\Domain\Command\Handler;

final class CreateBuilding implements Handler
{
    public function __construct(private readonly BuildingRepository $buildingRepository)
    {
    }

    public function __invoke(Command $command): AggregateRoot
    {
        assert($command instanceof CreateBuildingCommand);
        $aggregateRoot = Building::fromName($command->name());
        $this->buildingRepository->store($aggregateRoot);

        // Not sure if this is a good idea here
        $this->buildingRepository->store($aggregateRoot);

        return $aggregateRoot;
    }
}