<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

use PayZero\App\Entity\Currency;
use PayZero\App\Exception\CurrencyNotFound;

interface ExchangeRateProvider
{
    public function getBaseCurrency(): Currency;

    /**
     * @throws CurrencyNotFound
     */
    public function getExchangeRate(Currency $currency): string;
}
