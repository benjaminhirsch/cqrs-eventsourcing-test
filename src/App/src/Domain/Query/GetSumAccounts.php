<?php

declare(strict_types=1);

namespace App\Domain\Query;

final class GetSumAccounts
{
    private int $sum;

    public function setSum(int $sum): self
    {
        $this->sum = $sum;
        return $this;
    }

    public function getSum(): int
    {
        return $this->sum;
    }
}