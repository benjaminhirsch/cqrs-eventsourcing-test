<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Event;

use App\Domain\Event\Event;

final class DoNothing
{
    public function __invoke(Event $event) :void
    {

    }
}