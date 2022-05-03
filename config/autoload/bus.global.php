<?php

declare(strict_types=1);

use App\Domain\Command\ChangeBuildingName;
use App\Domain\Command\CreateBuilding;
use App\Domain\CommandBus;
use App\Domain\Event\BuildingCreated;
use App\Domain\Event\BuildingNameChanged;
use App\Domain\EventBus;
use App\Domain\QueryBus;
use App\Infrastructure\Handler;

return [
    CommandBus::class => [
        CreateBuilding::class => [Handler\Command\CreateBuilding::class],
        ChangeBuildingName::class => [Handler\Command\ChangeBuildingName::class],
    ],
    QueryBus::class => [],
    EventBus::class => [
        BuildingCreated::class => [Handler\Event\BuildingCreated::class],
        BuildingNameChanged::class => [Handler\Event\BuildNameChanged::class],
    ],
];
