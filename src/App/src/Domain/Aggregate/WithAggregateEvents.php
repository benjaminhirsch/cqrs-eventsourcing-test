<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Event\Event;

trait WithAggregateEvents
{
    private array $recordedEvents = [];
    
    protected function recordThat(Event $event): void
    {
        $this->recordedEvents[] = $event;
        $this->apply($event);
    }

    /**
     * @return Event[]
     */
    public function getRecordedEvents(): array
    {
        $recordedEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $recordedEvents;
    }

    abstract protected function apply(Event $event): void;
}