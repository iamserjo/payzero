<?php

declare(strict_types=1);

namespace PayZero\App\Validator;

use PayZero\App\Contract\Validator;
use PayZero\App\Exception\ExchangeRateClientInvalidResponse;

class ExchangeRateClient implements Validator
{
    /**
     * @throws ExchangeRateClientInvalidResponse
     */
    public function validate($data): void
    {
        if (empty($data['base']) || empty($data['rates'])) {
            throw new ExchangeRateClientInvalidResponse('Invalid response from exchange rate API');
        }
    }
}
