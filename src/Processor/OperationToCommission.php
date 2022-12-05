<?php

declare(strict_types=1);

namespace PayZero\App\Processor;

use Generator;
use PayZero\App\Contract\ExchangeRateProvider;
use PayZero\App\Entity\Operation;
use PayZero\App\Exception\CurrencyNotFound;
use PayZero\App\Factory\Rule;
use PayZero\App\Service\ExchangeRateConvertor;

class OperationToCommission
{
    public const NO_FEE_AMOUNT = '1000';
    public const NO_FEE_TRANSACTION_COUNT = 3;
    private const START_RANGE_PATTERN = 'monday this week';
    private const END_RANGE_PATTERN = 'sunday this week';

    /**
     * Pool of dates: weeks.
     */
    private array $commissionsGroupedByWeek = [];

    private ExchangeRateConvertor $exchangeRateConvertor;

    /**
     * @param array|Generator      $operations
     * @param ExchangeRateProvider $exchangeRateProvider
     */
    public function __construct(
        private readonly array|Generator $operations, // array is used for testing, generator for the rest
        private readonly ExchangeRateProvider $exchangeRateProvider
    ) {
        $this->exchangeRateConvertor = new ExchangeRateConvertor($this->exchangeRateProvider);
        $this->groupByWeeks(); // group by weeks first
    }

    /**
     * @throws CurrencyNotFound
     */
    public function getCalculatedOperations(): Generator
    {
        // using already grouped operations by week
        foreach ($this->commissionsGroupedByWeek as $groupedByWeek) {
            $remainNoFeeAmount = self::NO_FEE_AMOUNT;
            $operationCounter = self::NO_FEE_TRANSACTION_COUNT;

            /** @var Operation[] $groupedByWeek */
            foreach ($groupedByWeek as $operation) {
                // converting remain no fee amount to currency of operation
                $remainNoFeeAmount = $this->exchangeRateConvertor->convert(
                    $remainNoFeeAmount,
                    $operation->getCurrency()
                );

                // creating one of three rules
                $rule = Rule::create(
                    $this->exchangeRateConvertor,
                    $operation,
                    $remainNoFeeAmount,
                    $operationCounter
                );
                $rule->calculate();
                // return counter to pass it from the loop to rule again
                $operationCounter = $rule->getRemainNoFeeOperationCount();
                // return remain no fee amount to pass it from the loop to rule again
                $remainNoFeeAmount = $this->exchangeRateConvertor->convertToBaseCurrency(
                    $rule->getRemainNoFeeAmount(),
                    $operation->getCurrency(),
                );
                yield $operation;
            }
        }
    }

    /**
     * Group weeks to work easier with calculations further.
     */
    public function groupByWeeks(): void
    {
        foreach ($this->operations as $operation) {
            $groupByString = $this->getGroupByString($operation);
            $this->commissionsGroupedByWeek[$groupByString][] = $operation;
        }
    }

    /**
     * Pattern to group by weeks. The key string will be like: first week day + last week day + userId + operation type
     * Example: 2022-12-05_2022-12-11_123_deposit.
     */
    private function getGroupByString(Operation $operation): string
    {
        $operationUnixTimeStamp = (int) $operation->getDate()->format('U');

        return date('Y-m-d', strtotime(self::START_RANGE_PATTERN, $operationUnixTimeStamp))
        .'_'.
        date('Y-m-d', strtotime(self::END_RANGE_PATTERN, $operationUnixTimeStamp))
        .'_'.
        $operation->getUser()->getId()
        .'_'.
        $operation->getOperationType()->getTypeName();
    }
}
