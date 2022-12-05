<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Entity\Currency;
use PayZero\App\Exception\CurrencyNotFound;

class ExchangeRateConvertor
{
    public function __construct(private readonly \PayZero\App\Contract\ExchangeRateProvider $exchangeRate)
    {
    }

    /**
     * @throws CurrencyNotFound
     */
    public function convert(string $amount, Currency $to): string
    {
        // scale 3 used to roundUp correctly in the future
        return bcmul($amount, $this->exchangeRate->getExchangeRate($to), 3);
    }

    /**
     * @throws CurrencyNotFound
     */
    public function convertToBaseCurrency(string $amount, Currency $to): string
    {
        // scale 3 used to roundUp correctly in the future
        return bcdiv($amount, $this->exchangeRate->getExchangeRate($to), 3);
    }

    /**
     * Round up is used to make
     * 0.01 to 1 when precision 0
     * 0.023 to 0.03 when precision 2.
     */
    public function roundUp(string $value, $precision): string
    {
        $value = (float) $value;
        $pow = pow(10, $precision);
        $float = ((ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow);

        return number_format($float, $precision, '.', '');
    }
}
