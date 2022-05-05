<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Event\Event;
use Ramsey\Uuid\UuidInterface;

trait WithAggregateEvents
{
    private array $recordedEvents = [];
    
    protected function recordThat(Event $event): void
    {
        $this->apply($event);
        $this->recordedEvents[] = $event;
    }

    /**
     * @param Event[] $events
     */
    public static function reconstituteFromEvents(UuidInterface $id, array $events): static
    {
        $aggregate = new static($id);
        array_map(static fn(Event $event) => $aggregate->apply($event), $events);
        return $aggregate;
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