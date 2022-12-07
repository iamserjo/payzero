<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

use PayZero\App\Service\ExchangeRateConvertor;

interface Rule
{
    public function __construct(
        ExchangeRateConvertor $exchangeRateConvertor,
        array $operations,
    );

    public function calculate(): \Generator;
}
