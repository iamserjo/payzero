<?php

declare(strict_types=1);

namespace PayZero\App\Service\ExchangeRate;

use PayZero\App\Entity\Currency;

class ExchangeRateConvertor
{
    public function __construct(private readonly ExchangeRate $exchangeRate)
    {
    }

    public function convert(string $amount, Currency $to): string
    {
        return bcdiv($amount, $this->exchangeRate->getExchangeRate($to), 2);
    }
}
