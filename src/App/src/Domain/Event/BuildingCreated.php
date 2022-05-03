<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class BuildingCreated extends Event
{
    public function name(): string
    {
        return $this->payload['name'];
    }
}