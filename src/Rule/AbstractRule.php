<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

use PayZero\App\Contract\Rule;
use PayZero\App\Entity\Operation;

abstract class AbstractRule implements Rule
{
    public function __construct(private readonly Operation $operation,
                                private readonly string $baseCurrencyAmount,
                                private string $remainNoFeeAmount)
    {
    }

    public function getRemainNoFeeAmount(): string
    {
        return $this->remainNoFeeAmount;
    }

    abstract public function process(): self;

    public function getOperation(): Operation
    {
        return $this->operation;
    }

    public function getBaseCurrencyAmount(): string
    {
        return $this->baseCurrencyAmount;
    }

    public function setRemainNoFeeAmount(string $remainNoFeeAmount): self
    {
        $this->remainNoFeeAmount = $remainNoFeeAmount;

        return $this;
    }
}
