<?php

declare(strict_types=1);

namespace App\Domain\Command;

use Ramsey\Uuid\UuidInterface;

final class ChangeBuildingName extends Command
{

    public function id(): UuidInterface
    {
        return $this->payload['id'];
    }

    public function name(): string
    {
        return $this->payload['name'];
    }
}