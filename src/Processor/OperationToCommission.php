<?php

declare(strict_types=1);

namespace PayZero\App\Processor;

use PayZero\App\Entity\Operation;
use PayZero\App\Factory\Rule;
use PayZero\App\Service\ExchangeRate\ExchangeRate;
use PayZero\App\Service\ExchangeRate\ExchangeRateConvertor;

class OperationToCommission
{
    public const NO_FEE_AMOUNT = '1000';
    public const NO_FEE_TRANSACTIONS = 3;
    private const START_RANGE_PATTERN = 'monday this week';
    private const END_RANGE_PATTERN = 'sunday this week';

    /**
     * Pool of dates: weeks.
     */
    private array $commissionPool = [];

    private ExchangeRateConvertor $exchangeRateConvertor;

    /**
     * @param Operation[] $operations
     */
    public function __construct(
        private readonly array $operations,
        private ExchangeRate $exchangeRate
    ) {
        $this->exchangeRate = new ExchangeRate();
        $this->exchangeRateConvertor = new ExchangeRateConvertor($this->exchangeRate);
        $this->groupByPattern();
    }

    /**
     * @return Operation[]
     */
    public function getCalculatedCommissions(): array
    {
        return $this->calculateCommission();
    }

    /**
     * @return Operation[]
     */
    private function calculateCommission(): array
    {
        $resultOperations = [];
        foreach ($this->commissionPool as $groupedPool) {
            $remainNoFeeAmount = self::NO_FEE_AMOUNT;
            var_dump('===============');

            /** @var Operation[] $groupedPool */
            foreach ($groupedPool as $operation) {
                $resultOperations[] = $operation;
                var_dump('---');

                $baseCurrencyAmount = $this->exchangeRateConvertor->convert(
                    $operation->getAmount(),
                    $operation->getCurrency()
                );

                // TODO: precision for JPY/rest
                $remainNoFeeAmount = Rule::create($operation, $baseCurrencyAmount, $remainNoFeeAmount)
                    ->process()
                    ->getRemainNoFeeAmount();

                var_dump('base amount '.$baseCurrencyAmount);
            }
        }

        return $resultOperations;
    }

    public function groupByPattern()
    {
        foreach ($this->operations as $operation) {
            $groupByString = $this->getGroupByString($operation);
            $this->commissionPool[$groupByString][] = $operation;
        }
    }

    private function getGroupByString(Operation $operation): string
    {
        $operationUnixTimeStamp = (int) $operation->getDate()->format('U');

        return date('Y-m-d', strtotime(self::START_RANGE_PATTERN, $operationUnixTimeStamp))
        .'_'.
        date('Y-m-d', strtotime(self::END_RANGE_PATTERN, $operationUnixTimeStamp))
        .'_'.
        $operation->getUser()->getId()
        .'_'.
        $operation->getOperationType()->getTypeName()
        .'_'.
        $operation->getCurrency()->getCurrencyCode();
    }
}
