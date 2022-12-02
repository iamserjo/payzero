<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

class Currency
{
    private string $exchangeRate;

    public function __construct(private readonly string $currencyCode)
    {
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getExchangeRate(): string
    {
        return $this->exchangeRate;
    }

    public function setExchangeRate(string $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }
}
