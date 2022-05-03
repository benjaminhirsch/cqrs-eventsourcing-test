<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Event\BuildingCreated;
use App\Domain\Event\BuildingNameChanged;
use App\Domain\Event\Event;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Building extends AggregateRoot
{
    private UuidInterface $id;
    private string $name;

    public static function create(string $name): self
    {
        $aggregate = new self;
        $aggregate->recordThat(BuildingCreated::occur(Uuid::uuid4(), [
            'name' => $name
        ]));

        return $aggregate;
    }

    public function changeBuildingName(string $name): void
    {
        if ($this->name === $name) {
            return;
        }

        $this->recordThat(BuildingNameChanged::occur($this->id, [
            'name' => $name
        ]));
    }

    protected function apply(Event $event): void
    {
        switch(get_class($event)) {
            case BuildingCreated::class:
            case BuildingNameChanged::class:
                $this->id = $event->id();
                $this->name = $event->name();
                break;
        }
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}