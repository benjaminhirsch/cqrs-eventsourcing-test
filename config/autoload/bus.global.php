<?php

declare(strict_types=1);

use App\Domain\Command\CreateAccount;
use App\Domain\CommandBus;
use App\Domain\Event\AccountWasCreated;
use App\Domain\EventBus;
use App\Domain\Query\GetSumAccounts;
use App\Domain\QueryBus;
use App\Infrastructure\Handler;

return [
    CommandBus::class => [
        CreateAccount::class => [Handler\Command\CreateAccount::class],
    ],
    QueryBus::class => [
        GetSumAccounts::class => [Handler\Query\GetSumAccounts::class]
    ],
    EventBus::class => [
        AccountWasCreated::class => [Handler\Event\AccountWasCreated::class]
    ],
];
