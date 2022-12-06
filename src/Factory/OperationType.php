<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\OperationType as OperationTypeInterface;
use PayZero\App\Entity\Operation\DepositType;
use PayZero\App\Entity\Operation\WithdrawType;
use PayZero\App\Exception\FactoryCreationFailure;

class OperationType
{
    /**
     * @throws FactoryCreationFailure
     */
    public static function create($typeName): OperationTypeInterface
    {
        return match ($typeName) {
            'withdraw' => new WithdrawType($typeName),
            'deposit' => new DepositType($typeName),
            'default' => throw new FactoryCreationFailure('client type '.$typeName.' creation failure')
        };
    }
}
