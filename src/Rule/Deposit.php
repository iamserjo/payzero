<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class Deposit extends AbstractRule
{
    public function calculate(): self
    {
        $this->getOperation()->getCommission()->setCommissionAmount(
            bcmul(
                $this->getOperation()->getAmount(), '0.0003', 2
            )
        );
        var_dump('deopsit commission '.$this->getOperation()->getCommission()->getCommissionAmount());

        return $this;
    }

    public function getCalculatedNoFeeOperationCount(): int
    {
        return $this->getRemainNoFeeOperationCount();
    }
}
