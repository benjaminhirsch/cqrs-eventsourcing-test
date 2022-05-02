<?php

declare(strict_types=1);

namespace App\Domain\Aggregator;

use App\Domain\Event\Event;
use App\Domain\EventBus;

trait WithAggregateEvents
{
    private function recordThat(Event $event, EventBus $eventBus): self
    {
        $eventBus->dispatch($event);
        return $this;
    }
}