<?php

declare(strict_types=1);

namespace App\Domain\Aggregator;

use App\Domain\AggregateRepository;
use App\Domain\Command\CreateAccount;
use App\Domain\Event\AccountWasCreated;
use App\Domain\EventBus;

final class Account implements AggregateRoot
{
    use WithAggregateEvents;

    private function __construct(public readonly int $accountNumber, public readonly string $accountHolderName)
    {
    }

    public static function create(CreateAccount $command, EventBus $eventBus, AggregateRepository $aggregateRepository): self
    {
        $aggregate = (new self($command->accountNumber, $command->accountHolderName))
            ->recordThat(new AccountWasCreated($command->accountNumber), $eventBus);

        $aggregateRepository->addAggregateRoot($aggregate);
        return $aggregate;
    }
}