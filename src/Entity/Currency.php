<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

class Currency
{
    public function __construct(private readonly string $currencyCode)
    {
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}
