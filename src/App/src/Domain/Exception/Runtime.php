<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use RuntimeException;
use Throwable;

class Runtime extends RuntimeException
{
    public static function create(string $message, int $code = 0, ?Throwable $throwable = null): RuntimeException
    {
        return new static($message, $code, $throwable);
    }
}
