<?php

declare(strict_types=1);

namespace App\Domain\Command;

use Ramsey\Uuid\UuidInterface;

final class UserCheckedOut extends Command
{
    public function user(): string
    {
        return $this->payload['userName'];
    }

    public static function ofBuilding(UuidInterface $uuid, string $userName): self
    {
        return self::fromArray([
            'id' => $uuid,
            'userName' => $userName
        ]);
    }
}