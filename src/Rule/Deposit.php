<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class Deposit extends AbstractRule
{
    public const COMMISSION_PERCENTAGE = '0.03';

    public function calculate(): void
    {
        $this->getOperation()->getCommission()->setCommissionAmount(
            $this->getExchangeRateConvertor()->roundUp(
                bcmul(
                    $this->getOperation()->getAmount(),
                    (string) (self::COMMISSION_PERCENTAGE / 100),
                    3
                ),
                $this->getOperation()->getAmountPrecision()
            )
        );
    }
}
