<?php

declare(strict_types=1);

namespace PayZero\App\Console;

class ExchangeRateClient
{
    public const API_URL = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';
    public const SAVE_TO_FILE_NAME = 'exchange-rate.json';

    public function __construct()
    {
    }

    private function getApiResponse(): bool|string
    {
        return file_get_contents(self::API_URL);
    }

    public function saveToFile()
    {
        file_put_contents($this->getApiResponse(), $this->getPath());
    }

    private function getPath(): string
    {
        return ROOT_DIR.DIRECTORY_SEPARATOR.self::SAVE_TO_FILE_NAME;
    }
}
