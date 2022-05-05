<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Command;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\Command\Command;
use App\Domain\Command\CreateBuilding as CreateBuildingCommand;
use App\Domain\Command\Handler;

final class CreateBuilding extends Handler
{
    public function __invoke(Command $command): AggregateRoot
    {
        assert($command instanceof CreateBuildingCommand);
        $aggregateRoot = Building::fromName($command->name());
        $this->aggregateRepository->addAggregateRoot($aggregateRoot);

        return $aggregateRoot;
    }
}