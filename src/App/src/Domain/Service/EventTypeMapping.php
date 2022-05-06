<?php

declare(strict_types=1);

namespace App\Domain\Service;

use Webmozart\Assert\Assert;

final class EventTypeMapping
{
    public function __construct(private readonly array $keyValueMapping)
    {
        foreach($this->keyValueMapping as $key => $value) {
            Assert::notEmpty($key);
            Assert::notEmpty($value);
        }
    }

    public function exists(string $key): bool
    {
        return isset($this->keyValueMapping[$key]);
    }

    public function map(string $key): string
    {
        return $this->keyValueMapping[$key];
    }
}