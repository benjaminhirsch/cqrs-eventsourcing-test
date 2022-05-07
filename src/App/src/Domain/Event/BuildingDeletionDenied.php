<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class BuildingDeletionDenied extends Event
{
    public static function eventTypeName(): string
    {
        return 'building.deletionDenied';
    }
}