<?php

declare(strict_types=1);

use App\Domain\Event;
use App\Domain\Service\EventTypeMapping;
use App\Factory\Service\EventTypeMappingFactory;

return [
    'dependencies' => [
        'factories' => [
            EventTypeMapping::class => EventTypeMappingFactory::class
        ]
    ],
   'eventTypeMapping' => [
       'building.created' => Event\BuildingCreated::class,
       'building.name_changed' => Event\BuildingNameChanged::class,
       'building.checkIn' => Event\UserCheckedIn::class,
       'building.checkOut' => Event\UserCheckedOut::class,
       'building.doubleCheckInDetected' => Event\DoubleCheckInDetected::class,
       'building.deleted' => Event\BuildingDeleted::class,
       'building.deletionDenied' => Event\BuildingDeletionDenied::class,
   ],
];
