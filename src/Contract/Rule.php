<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

use PayZero\App\Entity\Operation;
use PayZero\App\Service\ExchangeRateConvertor;

interface Rule
{
    public function __construct(
        ExchangeRateConvertor $exchangeRateConvertor,
        Operation $operation,
        string $remainNoFeeAmount,
        int $operationCounter
    );

    public function getRemainNoFeeAmount(): string;

    public function getRemainNoFeeOperationCount(): int;

    public function calculate(): void;
}
