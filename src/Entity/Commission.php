<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

class Commission
{
    private string $commissionAmount = '0';

    public function __construct()
    {
    }

    public function setCommissionAmount(string $commissionAmount): void
    {
        $this->commissionAmount = $commissionAmount;
    }

    public function getCommissionAmount(): string
    {
        return $this->commissionAmount;
    }
}
