<?php

declare(strict_types=1);

namespace PayZero\App\Service\ExchangeRate;

use PayZero\App\Entity\Currency;

class ExchangeRate
{
    public function __construct()
    {
        // config loader new ConfigFileLoader()
        // bridge new Bridge ConfigFileLoaderToExchangeRate
    }

    public function getBaseCurrency()
    {
        return new Currency('EUR');
    }

    public function getExchangeRate(Currency $currency)
    {
        // TODO: remove fake data
        return match ($currency->getCurrencyCode()) {
            'EUR' => '1',
            'USD' => '1.1497',
            'JPY' => '129.53',
        };
    }
}
