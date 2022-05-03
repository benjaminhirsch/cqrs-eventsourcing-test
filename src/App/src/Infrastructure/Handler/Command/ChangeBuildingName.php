<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Command;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\Command\Command;
use App\Domain\Command\Handler;
use App\Domain\Command\ChangeBuildingName as ChangeBuildingNameCommand;

final class ChangeBuildingName extends Handler
{
    public function __invoke(Command $command): AggregateRoot
    {
        assert($command instanceof ChangeBuildingNameCommand);
        $aggregateRoot = $this->aggregateRepository->findBy(Building::class, [$command->id()]);
        assert($aggregateRoot instanceof Building);
        $aggregateRoot->changeBuildingName($command->name());
        return $aggregateRoot;
    }
}