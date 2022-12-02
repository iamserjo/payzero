<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class PrivateWithdraw extends AbstractRule
{
    public const NO_FEE_OPERATION_NUMBER = 3;
    public const FEE_PERCENTAGE = '0.3';

    public function calculate(): self
    {
        $commissionPercent = self::NO_FEE_OPERATION_NUMBER > 3 ? self::FEE_PERCENTAGE / '100' : '1';

        //(3000000-(1000*129.53))*0.3/100*1
        //$this->getBaseCurrencyAmount()-($this->getRemainNoFeeAmount()*)

        // decrease number of no fee operations
        $this->setRemainNoFeeOperationCount($this->getRemainNoFeeOperationCount() + 1);



        if (($commissionFromAmount = bcsub($this->getBaseCurrencyAmount(), $this->getRemainNoFeeAmount())) <= 0) {
            // no fee logic
            $this->setRemainNoFeeAmount(bcsub($this->getRemainNoFeeAmount(), $this->getBaseCurrencyAmount()));
            $this->getOperation()->getCommission()->setCommissionAmount('0.00');

            $this->getOperation()->getCommission()->setCommissionAmount(
                bcmul(
                    $commissionFromAmount, $commissionPercent, 2
                )
            );

            var_dump('remain no fee < 0  '.$this->getRemainNoFeeAmount());
            var_dump('commission '.$this->getOperation()->getCommission()->getCommissionAmount());
        } else { // apply the fee
            $this->setRemainNoFeeAmount('0');
            $this->getOperation()->getCommission()->setCommissionAmount(
                bcmul(
                    $commissionFromAmount, $commissionPercent, 2
                )
            );

            var_dump("comissionfromamount $commissionFromAmount, percent $commissionPercent");

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
