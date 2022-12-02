<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

class BusinessWithdraw extends AbstractRule
{
    public function calculate(): self
    {
        $this
            ->getOperation()
            ->getCommission()
            ->setCommissionAmount(
                bcmul(
                    $this->getOperation()->getAmount(), '0.005', 2
                )
            );
        var_dump('business commission '.$this->getOperation()->getCommission()->getCommissionAmount());

        return $this;
    }
}
