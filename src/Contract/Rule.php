<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

use PayZero\App\Entity\Operation;

interface Rule
{
    public function __construct(Operation $operation, string $baseCurrencyAmount, string $remainNoFeeAmount);

    public function getRemainNoFeeAmount(): string;

    public function process(): self;
}
