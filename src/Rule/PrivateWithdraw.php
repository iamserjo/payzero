<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class PrivateWithdraw extends AbstractRule
{
    public const FEE_PERCENTAGE = '0.3';

    public function calculate(): void
    {
        if ($this->getRemainNoFeeOperationCount() !== 0) {
            // decrease number of no fee operations
            $this->setRemainNoFeeOperationCount($this->getRemainNoFeeOperationCount() - 1);
        } else {
            $this->setRemainNoFeeAmount('0');
        }

        if (($commissionFromAmount = bcsub($this->getOperation()->getAmount(), $this->getRemainNoFeeAmount())) <= 0) {
            // no fee logic
            $this->setRemainNoFeeAmount(bcsub($this->getRemainNoFeeAmount(), $this->getOperation()->getAmount()));

            $this->getOperation()->getCommission()->setCommissionAmount(
                $this->getExchangeRateConvertor()->roundUp(
                    '0',
                    $this->getOperation()->getAmountPrecision()
                )
            );
        } else { // apply the fee
            $this->setRemainNoFeeAmount('0');

            $commission = bcmul($commissionFromAmount, (string) (self::FEE_PERCENTAGE / 100), 3);
            $commission = $this->getExchangeRateConvertor()->roundUp(
                $commission,
                $this->getOperation()->getAmountPrecision()
            );

            $this->getOperation()->getCommission()->setCommissionAmount($commission);
        }
    }
}
