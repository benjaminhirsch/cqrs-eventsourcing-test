<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Command;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\BuildingRepository;
use App\Domain\Command\Command;
use App\Domain\Command\Handler;
use App\Domain\Command\ChangeBuildingName as ChangeBuildingNameCommand;

final class ChangeBuildingName implements Handler
{
    public function __construct(private readonly BuildingRepository $buildingRepository)
    {
    }

    public function __invoke(Command $command): AggregateRoot
    {
        assert($command instanceof ChangeBuildingNameCommand);
        $aggregateRoot = $this->buildingRepository->findBy($command->aggregateRootId()->toString());
        assert($aggregateRoot instanceof Building);
        $aggregateRoot->changeBuildingName($command->name());

        // Not sure if this is a good idea here
        $this->buildingRepository->store($aggregateRoot);

        return $aggregateRoot;
    }
}