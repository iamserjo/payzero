<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class BusinessWithdraw extends AbstractRule
{
    public const FEE_PERCENTAGE = '0.5';

    public function calculate(): void
    {
        $this
            ->getOperation()
            ->getCommission()
            ->setCommissionAmount(
                $this->getExchangeRateConvertor()->roundUp(
                    bcmul(
                        $this->getOperation()->getAmount(), (string) (self::FEE_PERCENTAGE / 100), 3
                    ),
                    $this->getOperation()->getAmountPrecision()
                )
            );
    }
}
