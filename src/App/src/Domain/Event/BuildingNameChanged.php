<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class BuildingNameChanged extends Event
{
    public function name(): string
    {
        return $this->payload['name'];
    }

    public static function eventTypeName(): string
    {
        return 'building.name_changed';
    }
}