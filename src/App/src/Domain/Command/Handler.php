<?php

namespace App\Domain\Command;

use App\Domain\Aggregate\AggregateRoot;

interface Handler
{
    public function __invoke(Command $command): AggregateRoot;
}