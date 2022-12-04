<?php

declare(strict_types=1);

namespace PayZero\App\Tests\FakeService;

use PayZero\App\Entity\Currency;

class ExchangeRateProvider extends \PayZero\App\Service\ExchangeRateProvider
{
    public function __construct()
    {
        //no parent call needed
    }

    public function getBaseCurrency(): Currency
    {
        return new Currency('EUR');
    }

    public function getExchangeRate(Currency $currency): string
    {
        return match ($currency->getCurrencyCode()) { //old exchange rate values from the homework
            'EUR' => '1',
            'USD' => '1.1497',
            'JPY' => '129.53',
        };
    }
}
