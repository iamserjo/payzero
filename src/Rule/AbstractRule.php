<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

use PayZero\App\Contract\Rule;
use PayZero\App\Entity\Operation;
use PayZero\App\Service\ExchangeRateConvertor;

abstract class AbstractRule implements Rule
{
    public function __construct(
        private readonly ExchangeRateConvertor $exchangeRateConvertor,
        private readonly Operation $operation,
        private string $remainNoFeeAmount,
        private int $remainNoFeeOperationCount
    ) {
    }

    public function getRemainNoFeeAmount(): string
    {
        return $this->remainNoFeeAmount;
    }

    abstract public function calculate(): void;

    public function getOperation(): Operation
    {
        return $this->operation;
    }

    public function getExchangeRateConvertor(): ExchangeRateConvertor
    {
        return $this->exchangeRateConvertor;
    }

    public function getRemainNoFeeOperationCount(): int
    {
        return $this->remainNoFeeOperationCount;
    }

    public function setRemainNoFeeAmount(string $remainNoFeeAmount): void
    {
        $this->remainNoFeeAmount = $remainNoFeeAmount;
    }

    public function setRemainNoFeeOperationCount(int $remainNoFeeOperationCount): void
    {
        $this->remainNoFeeOperationCount = $remainNoFeeOperationCount;
    }
}
