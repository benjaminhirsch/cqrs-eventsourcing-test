<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Query;

use App\Domain\AggregateRepository;
use App\Domain\Aggregator\Account;

final class GetSumAccounts
{
    public function __construct(private readonly AggregateRepository $aggregateRepository)
    {
    }

    public function __invoke(\App\Domain\Query\GetSumAccounts $getSumAccounts): \App\Domain\Query\GetSumAccounts
    {
        return $getSumAccounts->setSum(count($this->aggregateRepository->findBy(Account::class, [])));
    }
}