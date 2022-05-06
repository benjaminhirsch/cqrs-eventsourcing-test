<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\Service\EventTypeMapping;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

abstract class AggregateRootRepository
{
    public function __construct(protected PDO $connection, protected EventTypeMapping $eventTypeMapping)
    {
    }

    public function findBy(string $aggregateRootId): AggregateRoot
    {
        $aggregateRootId = Uuid::fromString($aggregateRootId);
        return Building::reconstituteFromEvents($aggregateRootId, $this->retrieveEvents($aggregateRootId));
    }

    public function store(AggregateRoot $aggregateRoot): void
    {
        try {
            $this->connection->beginTransaction();
            foreach ($aggregateRoot->getRecordedEvents() as $event) {
                $statement = $this->connection->prepare('INSERT INTO events (type, uuid, body) VALUES (?, ?, ?)');
                $statement->execute([
                    $event::eventTypeName(),
                    $aggregateRoot->id,
                    json_encode($event)
                ]);
            }
            $this->connection->commit();
        } catch (PDOException $exception) {
            $this->connection->rollBack();
            echo $exception->getMessage();
        }
    }
}