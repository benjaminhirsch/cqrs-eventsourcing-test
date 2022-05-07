<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler\Event;


use App\Domain\Event\DoubleCheckInDetected as DoubleCheckInDetectedEvent;

final class DoubleCheckInDetected
{
    public function __invoke(DoubleCheckInDetectedEvent $event) :void
    {
        error_log('Double check in detected for user ' . $event->userName());
    }
}