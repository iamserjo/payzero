<?php

namespace PayZero\App\Contract;

use PayZero\App\Entity\Currency;

interface ExchangeRateProvider
{
    public function getBaseCurrency(): Currency;
    public function getExchangeRate(Currency $currency): string;
}