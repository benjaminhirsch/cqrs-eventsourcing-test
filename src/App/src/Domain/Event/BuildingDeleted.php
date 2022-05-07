<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class BuildingDeleted extends Event
{
    public static function eventTypeName(): string
    {
        return 'building.deleted';
    }
}