<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class PrivateWithdraw extends AbstractRule
{
    public const NO_FEE_OPERATION_NUMBER = 3;
    public const FEE_PERCENTAGE = '0.3';

    public function calculate(): self
    {
        if ($this->getRemainNoFeeOperationCount() !== 0) {
            // decrease number of no fee operations
            $this->setRemainNoFeeOperationCount($this->getRemainNoFeeOperationCount() - 1);
        } else {
            $this->setRemainNoFeeAmount('0');
        }

        if (($commissionFromAmount = bcsub($this->getBaseCurrencyAmount(), $this->getRemainNoFeeAmount())) <= 0) {
            // no fee logic
            $this->setRemainNoFeeAmount(bcsub($this->getRemainNoFeeAmount(), $this->getBaseCurrencyAmount()));

            $this->getOperation()->getCommission()->setCommissionAmount(
                $this->getExchangeRateConvertor()->roundUp(
                    '0',
                    $this->getOperation()->getAmountPrecision()
                )
            );

            var_dump('remain no fee < 0  '.$this->getRemainNoFeeAmount());
            var_dump('commission '.$this->getOperation()->getCommission()->getCommissionAmount());
        } else { // apply the fee
            $this->setRemainNoFeeAmount('0');

            $commission = bcmul($commissionFromAmount, (string) (self::FEE_PERCENTAGE / 100), 3);
            var_dump("comission from amount $commissionFromAmount percent ".(string) (self::FEE_PERCENTAGE / 100));
            var_dump('Multiplied '.$commission);
            $commission = $this->getExchangeRateConvertor()->roundUp(
                $commission,
                $this->getOperation()->getAmountPrecision()
            );

            $this->getOperation()->getCommission()->setCommissionAmount($commission);

            var_dump('remain no fee! '.$this->getRemainNoFeeAmount());

            var_dump('commission '.$this->getOperation()->getCommission()->getCommissionAmount());
        }

        return $this;
    }

    public function getCalculatedNoFeeOperationCount(): int
    {
        return $this->getRemainNoFeeOperationCount() + 1;
    }
}
