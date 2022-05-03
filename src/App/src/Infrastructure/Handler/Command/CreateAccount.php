<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Command;

use App\Domain\AggregateRepository;
use App\Domain\Aggregate\Account;
use App\Domain\Aggregate\AggregateRoot;
use App\Domain\Command\Command;
use App\Domain\Command\Handler;
use App\Domain\EventBus;

class CreateAccount implements Handler
{
    public function __construct(
        private readonly EventBus $eventBus,
        private readonly AggregateRepository $aggregateRepository
    )
    {
    }

    public function __invoke(Command $command): AggregateRoot
    {
        return Account::create($command, $this->eventBus, $this->aggregateRepository);
    }
}