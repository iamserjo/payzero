<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

use PayZero\App\Entity\Currency;

interface ExchangeRateProvider
{
    public function getBaseCurrency(): Currency;

    public function getExchangeRate(Currency $currency): string;
}
