<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Entity\Currency;
use PayZero\App\Exception\CurrencyNotFound;

class ExchangeRateConvertor
{
    public function __construct(private readonly ExchangeRateProvider $exchangeRate)
    {
    }

    /**
     * @throws CurrencyNotFound
     */
    public function convert(string $amount, Currency $to): string
    {
        return bcdiv($amount, $this->exchangeRate->getExchangeRate($to), 2);
    }
}
