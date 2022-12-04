<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Contract\Validator;
use PayZero\App\Exception\EnvFileInvalid;
use PayZero\App\Exception\ExchangeRateClientInvalidResponse;
use PayZero\App\Validator\ExchangeRateClient as ExchangeRateClientValidator;

class ExchangeRateClient
{
    private Validator $validator;
    private array $structure = [];
    private string $apiUrl = '';

    /**
     * @throws ExchangeRateClientInvalidResponse
     * @throws EnvFileInvalid
     */
    public function __construct()
    {
        $this->validator = new ExchangeRateClientValidator();
        $this->readEnv();
        $this->saveInMemory();
    }

    private function getApiResponse(): bool|string
    {
        return file_get_contents($this->apiUrl);
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

    /**
     * @throws EnvFileInvalid
     */
    private function readEnv(): void
    {
        $this->apiUrl = getenv('EXCHANGE_RATE_API_URL') === false ?
            throw new EnvFileInvalid('.env file is missing or not configured') : getenv('EXCHANGE_RATE_API_URL');
    }
}
