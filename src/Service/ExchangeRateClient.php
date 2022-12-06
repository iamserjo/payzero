<?php

declare(strict_types=1);

namespace PayZero\App\Service;

use PayZero\App\Exception\EnvFileInvalid;
use PayZero\App\Exception\ExchangeRateClientInvalidResponse;
use PayZero\App\Validator\ExchangeRateClient as ExchangeRateClientValidator;

class ExchangeRateClient
{
    private array $structure = [];
    private string $apiUrl;

    /**
     * @throws ExchangeRateClientInvalidResponse
     * @throws EnvFileInvalid
     */
    public function __construct(private readonly ExchangeRateClientValidator $validator)
    {
        $this->readEnv();
        $this->saveInMemory();
    }

    private function getApiResponse(): bool|string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * @throws ExchangeRateClientInvalidResponse
     */
    private function saveInMemory(): void
    {
        // saving in memory. for real cases in should be singleton
        $this->structure = json_decode($this->getApiResponse(), true);
        $this->validator->validate($this->structure);
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
