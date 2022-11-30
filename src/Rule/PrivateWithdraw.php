<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class PrivateWithdraw extends AbstractRule
{
    public function process(): self
    {
        if (($commissionFromAmount = bcsub($this->getBaseCurrencyAmount(), $this->getRemainNoFeeAmount())) <= 0) {
            // no fee logic
            $this->setRemainNoFeeAmount(bcsub($this->getRemainNoFeeAmount(), $this->getBaseCurrencyAmount()));
            $this->getOperation()->getCommission()->setCommissionAmount('0.00');

//            var_dump('remain no fee < 0  ' . $this->getRemainNoFeeAmount());
//            var_dump('commission ' . $this->getOperation()->getCommission()->getCommissionAmount());
        } else { // apply the fee
            $this->setRemainNoFeeAmount('0');
            $this->getOperation()->getCommission()->setCommissionAmount(
                bcmul(
                    $commissionFromAmount, '0.003', 2
                )
            );

//            var_dump('remain no fee! ' . $this->getRemainNoFeeAmount());
//            var_dump('commission ' . $this->getOperation()->getCommission()->getCommissionAmount());
        }

        return $this;
    }
}
