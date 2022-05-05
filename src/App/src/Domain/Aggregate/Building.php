<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Event\BuildingCreated;
use App\Domain\Event\BuildingNameChanged;
use App\Domain\Event\Event;
use Ramsey\Uuid\Uuid;

final class Building extends AggregateRoot
{
    private string $name;

    public static function fromName(string $name): self
    {
        $aggregate = new self(Uuid::uuid4());
        $aggregate->recordThat(BuildingCreated::occur([
            'name' => $name
        ]));

        return $aggregate;
    }

    public function changeBuildingName(string $name): void
    {
        //if ($this->name === $name) {
        //    return;
        //}

        $this->recordThat(BuildingNameChanged::occur([
            'name' => $name
        ]));
    }

    protected function apply(Event $event): void
    {
        switch($event::eventTypeName()) {
            case BuildingCreated::eventTypeName():
            case BuildingNameChanged::eventTypeName():
                $this->name = $event->name();
                break;
        }
    }

    public function name(): string
    {
        return $this->name;
    }
}