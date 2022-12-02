<?php

declare(strict_types=1);

namespace PayZero\App\Factory;

use PayZero\App\Contract\Rule as RuleInterface;
use PayZero\App\Entity\Operation;
use PayZero\App\Service\ExchangeRateConvertor;

class Rule
{
    public static function create(
        ExchangeRateConvertor $exchangeRateConvertor,
        Operation $operation,
        string $baseCurrencyAmount,
        string $remainNoFeeAmount,
        int $operationCounter
    ): RuleInterface {
        if ($operation->getOperationType() instanceof Operation\DepositType) {
            $class = $operation->getOperationType()->getRuleClass();
        } else {
            $class = $operation->getClientType()->getRuleClass();
        }

        return new $class($exchangeRateConvertor, $operation, $baseCurrencyAmount, $remainNoFeeAmount, $operationCounter);
    }
}
