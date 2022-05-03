<?php

namespace App\Domain\Command;

use App\Domain\Aggregate\AggregateRoot;
use App\Domain\AggregateRepository;

abstract class Handler
{
    public function __construct(protected readonly AggregateRepository $aggregateRepository)
    {
    }

    abstract public function __invoke(Command $command): AggregateRoot;
}