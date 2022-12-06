<?php

declare(strict_types=1);

namespace PayZero\App\Entity\Operation;

use PayZero\App\Contract\OperationType;
use PayZero\App\Rule\Deposit;

class DepositType implements OperationType
{
    public function __construct(protected string $typeName)
    {
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getRuleClass(): string
    {
        return Deposit::class;
    }
}
