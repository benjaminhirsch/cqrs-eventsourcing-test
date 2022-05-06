<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Command;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\BuildingRepository;
use App\Domain\Command\Command;
use App\Domain\Command\UserCheckedIn as UserCheckedInCommand;
use App\Domain\Command\Handler;

final class UserCheckedOut implements Handler
{
    public function __construct(private readonly BuildingRepository $buildingRepository)
    {
    }

    public function __invoke(Command $command): AggregateRoot
    {
        assert($command instanceof UserCheckedInCommand);
        $aggregateRoot = $this->buildingRepository->findBy($command->aggregateRootId()->toString());
        assert($aggregateRoot instanceof Building);
        $aggregateRoot->checkOutUser($command->user());

        // Not sure if this is a good idea here
        $this->buildingRepository->store($aggregateRoot);

        return $aggregateRoot;
    }
}