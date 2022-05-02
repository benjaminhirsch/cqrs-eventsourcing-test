<?php

declare(strict_types=1);

namespace App\Domain\Event;

final class AccountWasCreated implements Event
{
    public function __construct(public readonly int $accountNumber)
    {
    }
}