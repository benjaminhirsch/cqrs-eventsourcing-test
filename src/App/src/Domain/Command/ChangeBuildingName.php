<?php

declare(strict_types=1);

namespace App\Domain\Command;

final class ChangeBuildingName extends Command
{

    public function name(): string
    {
        return $this->payload['name'];
    }
}