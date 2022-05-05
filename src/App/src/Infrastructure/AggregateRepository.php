<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;

final class AggregateRepository implements \App\Domain\AggregateRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function findBy(string $aggregateRootId): AggregateRoot
    {
        try {
            $aggregateRootId = Uuid::fromString($aggregateRootId);

            $statement = $this->connection->prepare('SELECT uuid, type, body FROM events WHERE uuid = ?');
            $statement->execute([
                $aggregateRootId
            ]);

            return Building::reconstituteFromEvents($aggregateRootId, array_map(static fn(array $event) => \App\Domain\Event\BuildingCreated::occur(json_decode($event['body'], true)), $statement->fetchAll(PDO::FETCH_ASSOC)));
        } catch ( PDOException $exception ) {
            echo $exception->getMessage();
        }

    }

    public function addAggregateRoot(AggregateRoot $aggregateRoot): void
    {
        try {
            $this->connection->beginTransaction();
            foreach ($aggregateRoot->getRecordedEvents() as $event) {
                $statement = $this->connection->prepare('INSERT INTO events (type, uuid, body) VALUES (?, ?, ?)');
                $statement->execute([
                    $event::eventTypeName(),
                    $aggregateRoot->id,
                    json_encode($event->payload)
                ]);
            }
            $this->connection->commit();
        } catch ( PDOException $exception ) {
            $this->connection->rollBack();
            echo $exception->getMessage();
        }
    }
}