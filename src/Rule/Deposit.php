<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class Deposit extends AbstractRule
{
    public const FEE_PERCENTAGE = '0.03';

    public function calculate(): void
    {
        $this->getOperation()->getCommission()->setCommissionAmount(
            $this->getExchangeRateConvertor()->roundUp(
                bcmul(
                    $this->getOperation()->getAmount(),
                    (string) (self::FEE_PERCENTAGE / 100),
                    3// precision 3 used to round up correctly
                ),
                $this->getOperation()->getAmountPrecision()
            )
        );
    }
}
