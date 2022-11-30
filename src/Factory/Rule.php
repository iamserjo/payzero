<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\Rule as RuleInterface;
use PayZero\App\Entity\Operation;

class Rule
{
    public static function create(
        Operation $operation,
        string $baseCurrencyAmount,
        string $remainNoFeeAmount
    ): RuleInterface {
        if ($operation->getOperationType() instanceof Operation\DepositType) {
            $class = $operation->getOperationType()->getRuleClass();

            return new $class($operation, $baseCurrencyAmount, $remainNoFeeAmount);
        } else {
            $class = $operation->getClientType()->getRuleClass();

            return new $class($operation, $baseCurrencyAmount, $remainNoFeeAmount);
        }
    }
}
