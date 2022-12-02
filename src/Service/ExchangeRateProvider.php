<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Entity\Currency;
use PayZero\App\Exception\CurrencyNotFound;
use PayZero\App\Contract\ExchangeRateProvider as ExchangeRateProviderInterface;

class ExchangeRateProvider implements ExchangeRateProviderInterface
{
    public function __construct(protected readonly ExchangeRateClient $exchangeRateClient)
    {
    }

    public function getBaseCurrency(): Currency
    {
        return new Currency($this->exchangeRateClient->getBaseCurrencyCode());
    }

    /**
     * @throws CurrencyNotFound
     */
    public function getExchangeRate(Currency $currency): string
    {
        $exchangeRateList = $this->exchangeRateClient->getExchangeRateList();
        return (string) $exchangeRateList[$currency->getCurrencyCode()] ?? throw new CurrencyNotFound();
    }
}
