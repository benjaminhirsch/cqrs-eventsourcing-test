<?php

declare(strict_types=1);

namespace App\Domain\Command;

final class CreateBuilding extends Command
{
    /**
     * Refactor to name constructor with necessary params plus specific getters
     * See -> https://github.com/ShittySoft/kanbanbox-2020-cqrs-es-workshop/blob/feature/check-out/src/Domain/Command/CheckIn.php
     */

    public function name(): string
    {
        return $this->payload['name'];
    }
}