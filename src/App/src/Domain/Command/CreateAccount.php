<?php

declare(strict_types=1);

namespace App\Domain\Command;

final class CreateAccount implements Command
{
    public function __construct(public readonly int $accountNumber, public readonly string $accountHolderName)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'accountNumber' => $this->accountNumber,
            'accountHolderName' => $this->accountHolderName,
        ];
    }
}