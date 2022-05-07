<?php

declare(strict_types=1);

namespace App\Domain\Model;


use Ramsey\Uuid\UuidInterface;

final class Building
{
    public function __construct(
        public readonly UuidInterface $id,
        public readonly string $name,
        public readonly array $checkedIn
    ) {
    }
}