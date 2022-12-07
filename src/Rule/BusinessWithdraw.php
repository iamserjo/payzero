<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

use PayZero\App\Contract\Rule;
use PayZero\App\Entity\Operation;
use PayZero\App\Service\ExchangeRateConvertor;

class BusinessWithdraw implements Rule
{
    public const FEE_PERCENTAGE = '0.5';

    public function __construct(
        private readonly ExchangeRateConvertor $exchangeRateConvertor,
        private readonly array $operations,
    ) {
    }

    public function calculate(): \Generator
    {
        foreach ($this->operations as $operation) {
            /* @var $operation Operation */
            $operation
                ->getCommission()
                ->setCommissionAmount(
                    $this->exchangeRateConvertor->roundUp(
                        bcmul(
                            // precision 3 is used to round up correctly
                            $operation->getAmount(), (string) (self::FEE_PERCENTAGE / 100), 3
                        ),
                        $operation->getAmountPrecision()
                    )
                );
            yield $operation;
        }
    }
}
