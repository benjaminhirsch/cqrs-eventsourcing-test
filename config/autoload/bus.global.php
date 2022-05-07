<?php

declare(strict_types=1);

use App\Domain\Command;
use App\Domain\CommandBus;
use App\Domain\Event;
use App\Domain\EventBus;
use App\Domain\QueryBus;
use App\Infrastructure\Handler;

return [
    CommandBus::class => [
        Command\CreateBuilding::class => [Handler\Command\CreateBuilding::class],
        Command\ChangeBuildingName::class => [Handler\Command\ChangeBuildingName::class],
        Command\UserCheckedIn::class => [Handler\Command\UserCheckedIn::class],
        Command\UserCheckedOut::class => [Handler\Command\UserCheckedOut::class],
        Command\DeleteBuilding::class => [Handler\Command\DeleteBuilding::class],
    ],
    QueryBus::class => [],
    EventBus::class => [
        Event\BuildingCreated::class => [Handler\Event\BuildingCreated::class],
        Event\BuildingNameChanged::class => [Handler\Event\BuildNameChanged::class],
        Event\UserCheckedIn::class => [Handler\Event\DoNothing::class],
        Event\BuildingDeletionDenied::class => [Handler\Event\DoNothing::class],
        Event\UserCheckedOut::class => [Handler\Event\DoNothing::class],
        Event\BuildingDeleted::class => [Handler\Event\DoNothing::class],
        Event\DoubleCheckInDetected::class => [Handler\Event\DoubleCheckInDetected::class],
    ],
];
