<?php

declare(strict_types=1);

namespace App\Domain\Aggregate;

use App\Domain\Event\BuildingCreated;
use App\Domain\Event\BuildingNameChanged;
use App\Domain\Event\DoubleCheckInDetected;
use App\Domain\Event\UserCheckedIn;
use App\Domain\Event\UserCheckedOut;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;

final class Building extends AggregateRoot
{
    private string $name;
    /**
     * @var array<string, DateTimeInterface>
     */
    private array $checkedInUsers = [];

    public function name(): string
    {
        return $this->name;
    }

    public static function fromName(string $name): self
    {
        $aggregate = new self(Uuid::uuid4());
        $aggregate->recordThat(BuildingCreated::occur([
            'name' => $name
        ]));

        return $aggregate;
    }

    public function checkInUser(string $userName): void
    {

        $doubleCheckInDetected = isset($this->checkedInUsers[$userName]);
        $this->recordThat(UserCheckedIn::toBuilding($userName));

        if ($doubleCheckInDetected) {
            $this->recordThat(DoubleCheckInDetected::toBuilding($userName));
        }
    }

    public function checkOutUser(string $userName): void
    {
        $this->recordThat(UserCheckedOut::ofBuilding($userName));
    }

    public function changeBuildingName(string $name): void
    {
        if ($this->name === $name) {
            return;
        }

        $this->recordThat(BuildingNameChanged::occur([
            'name' => $name
        ]));
    }

    protected function whenUserCheckedIn(UserCheckedIn $event): void
    {
        $this->checkedInUsers[$event->userName()] = $event->dateTime();
    }

    protected function whenUserCheckedOut(UserCheckedOut $event): void
    {
        unset($this->checkedInUsers[$event->userName()]);
    }

    protected function whenBuildingCreated(BuildingCreated $event): void
    {
        $this->name = $event->name();
    }

    protected function whenBuildingNameChanged(BuildingNameChanged $event): void
    {
        $this->name = $event->name();
    }

    protected function whenDoubleCheckInDetected(DoubleCheckInDetected $event): void
    {
        // Do nothing on purpose
    }
}