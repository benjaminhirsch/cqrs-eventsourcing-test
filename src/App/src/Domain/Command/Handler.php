<?php

namespace App\Domain\Command;

use App\Domain\Aggregator\AggregateRoot;

interface Handler
{
    public function __invoke(Command $command): AggregateRoot;
}