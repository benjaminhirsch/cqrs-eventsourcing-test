<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Aggregate\Building;
use App\Domain\BuildingRepository as BuildingRepositoryInterface;
use App\Domain\Exception\MissingEventTypeMapping;
use Generator;
use PDO;
use PDOException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class BuildingRepository extends AggregateRootRepository implements BuildingRepositoryInterface
{
    public function findBy(string $aggregateRootId): AggregateRoot
    {
        $aggregateRootId = Uuid::fromString($aggregateRootId);
        return Building::reconstituteFromEvents($aggregateRootId, $this->retrieveEvents($aggregateRootId));
    }

    public function retrieveEvents(UuidInterface $aggregateRootId): Generator
    {
        try {
            $statement = $this->connection->prepare('SELECT uuid, type, body FROM events WHERE uuid = ?');
            $statement->execute([
                $aggregateRootId
            ]);

            foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $rawEvent) {
                if (! $this->eventTypeMapping->exists($rawEvent['type'])) {
                    throw MissingEventTypeMapping::create(sprintf(
                        'No event type mapping found for %s', $rawEvent['type']
                    ));
                }
                yield $this->eventTypeMapping->map($rawEvent['type'])::occur(json_decode($rawEvent['body'], true));
            }

        } catch ( PDOException $exception ) {
            echo $exception->getMessage();
        }
    }
}