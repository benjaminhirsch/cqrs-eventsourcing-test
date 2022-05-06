<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Event\Event;
use Generator;
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
     * @param Generator<Event> $events
     */
    public static function reconstituteFromEvents(UuidInterface $id, Generator $events): static
    {
        $aggregate = new static($id);
        foreach ($events as $event) {
            $aggregate->apply($event);
        }
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

    protected function apply(Event $event): void
    {
        $parts = explode('\\', get_class($event));
        $methodName = 'when' . end($parts);

        if (method_exists($this, $methodName)) {
            $this->{$methodName}($event);
        }
    }
}