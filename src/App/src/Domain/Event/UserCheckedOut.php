<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTimeInterface;

final class UserCheckedOut extends Event
{
    public function userName(): string
    {
        return $this->payload['userName'];
    }

    public function dateTime(): DateTimeInterface
    {
        return date_create_immutable($this->payload['dateTime']);
    }

    public static function eventTypeName(): string
    {
        return 'building.checkOut';
    }

    public static function ofBuilding(string $userName): self
    {
        return self::occur([
            'userName' => $userName,
            'dateTime' => date_create_immutable()->format('c'),
        ]);
    }
}