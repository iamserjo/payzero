<?php

declare(strict_types=1);

namespace PayZero\App\Tests\FakeService;

use PayZero\App\Entity\Currency;

class ExchangeRate extends \PayZero\App\Service\ExchangeRate\ExchangeRate
{
    public function getBaseCurrency()
    {
        return new Currency('EUR');
    }

    public function getExchangeRate(Currency $currency)
    {
        return match ($currency->getCurrencyCode()) {
            'EUR' => '1',
            'USD' => '1.1497',
            'JPY' => '129.53',
        };
    }
}
