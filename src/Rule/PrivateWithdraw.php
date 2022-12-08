<?php

declare(strict_types=1);

namespace PayZero\App\Rule;

use PayZero\App\Contract\Rule;
use PayZero\App\Entity\Operation;
use PayZero\App\Exception\CurrencyNotFound;
use PayZero\App\Service\ExchangeRateConvertor;

class PrivateWithdraw implements Rule
{
    public const FEE_PERCENTAGE = '0.3';
    public const NO_FEE_AMOUNT = '1000';
    public const NO_FEE_TRANSACTION_COUNT = 3;

    public function __construct(
        private readonly ExchangeRateConvertor $exchangeRateConvertor,
        private readonly array $operations,
    ) {
    }

    /**
     * @throws CurrencyNotFound
     */
    public function calculate(): \Generator
    {
        $remainNoFeeAmount = self::NO_FEE_AMOUNT;
        $operationCounter = self::NO_FEE_TRANSACTION_COUNT;

        foreach ($this->getOperations() as $operation) {
            /** @var $operation Operation */

            // converting remain no fee amount to currency of operation
            $remainNoFeeAmount = $this->exchangeRateConvertor->convert(
                $remainNoFeeAmount,
                $operation->getCurrency()
            );

            if ($operationCounter !== 0) {
                // decrease number of no fee operations
                --$operationCounter;
            } else {
                $remainNoFeeAmount = '0';
            }

            if (($commissionFromAmount = bcsub($operation->getAmount(), $remainNoFeeAmount)) <= 0) {
                // no fee logic
                $remainNoFeeAmount = bcsub($remainNoFeeAmount, $operation->getAmount());

                $operation->getCommission()->setCommissionAmount(
                    $this->getExchangeRateConvertor()->roundUp(
                        '0',
                        $operation->getAmountPrecision()
                    )
                );
            } else { // apply the fee
                $remainNoFeeAmount = '0';

                // precision 3 used to round up correctly
                $commission = bcmul($commissionFromAmount, (string) (self::FEE_PERCENTAGE / 100), 3);
                $commission = $this->getExchangeRateConvertor()->roundUp(
                    $commission,
                    $operation->getAmountPrecision()
                );

                $operation->getCommission()->setCommissionAmount($commission);
            }

            $remainNoFeeAmount = $this->exchangeRateConvertor->convertToBaseCurrency(
                $remainNoFeeAmount,
                $operation->getCurrency(),
            );

            yield $operation;
        }
    }

    public function getOperations(): array
    {
        return $this->operations;
    }

    public function getExchangeRateConvertor(): ExchangeRateConvertor
    {
        return $this->exchangeRateConvertor;
    }
}
