<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Contract\Validator;
use PayZero\App\Exception\ExchangeRateClientInvalidResponse;
use PayZero\App\Validator\ExchangeRateClient as ExchangeRateClientValidator;

class ExchangeRateClient
{
    private const API_URL = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';
    private Validator $validator;
    private array $structure = [];

    /**
     * @throws ExchangeRateClientInvalidResponse
     */
    public function __construct()
    {
        $this->validator = new ExchangeRateClientValidator();
        $this->saveInMemory();
    }

    private function getApiResponse(): bool|string
    {
        return file_get_contents(self::API_URL);
    }

    /**
     * @throws ExchangeRateClientInvalidResponse
     */
    private function validate($data): void
    {
        $this->validator->validate($data);
    }

    /**
     * @throws ExchangeRateClientInvalidResponse
     */
    private function saveInMemory(): void
    {
        $this->structure = json_decode($this->getApiResponse(), true);
        $this->validate($this->structure);
    }

    public function getBaseCurrencyCode(): string
    {
        return (string) $this->structure['base'];
    }

    public function getExchangeRateList(): array
    {
        return (array) $this->structure['rates'];
    }
}
