<?php

declare(strict_types=1);

namespace PayZero\App\Entity\Operation;

use PayZero\App\Contract\OperationType;
use PayZero\App\Rule\PrivateWithdraw;

class WithdrawType implements OperationType
{
    protected string $typeName = '';

    public function setTypeName(string $name): void
    {
        $this->typeName = $name;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getRuleClass(): string
    {
        return PrivateWithdraw::class;
    }
}
