<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Entity\Currency;

class ExchangeRateConvertor
{
    public function __construct(private readonly \PayZero\App\Contract\ExchangeRateProvider $exchangeRate)
    {
    }

    public function convert(string $amount, Currency $to): string
    {
        return bcmul($amount, $this->exchangeRate->getExchangeRate($to), 2);
    }

    public function convertToBaseCurrency(string $amount, Currency $to): string
    {
        return bcdiv($amount, $this->exchangeRate->getExchangeRate($to), 2);
    }

    public function roundUp(string $value, $precision): string
    {
        $value = (float) $value;
        $pow = pow(10, $precision);
        $float = ((ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow);

        return number_format($float, $precision, '.', '');
    }
}
