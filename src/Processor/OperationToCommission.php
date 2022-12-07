<?php

declare(strict_types=1);

namespace PayZero\App\Processor;

use Generator;
use PayZero\App\Contract\ExchangeRateProvider;
use PayZero\App\Entity\Operation;
use PayZero\App\Factory\Rule;
use PayZero\App\Service\ExchangeRateConvertor;

class OperationToCommission
{
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
    }

    private function getRuleKeyByOperation(Operation $operation): string
    {
        if ($operation->getOperationType() instanceof Operation\DepositType) {
            return $operation->getOperationType()->getRuleClass();
        } else {
            return $operation->getClientType()->getRuleClass();
        }
    }

    private function getGroupedByWeekAndOperation(): Generator
    {
        $groupedByWeekAndRule = [];
        // using already grouped operations by week
        foreach ($this->groupByWeeks() as $key => $groupedByWeek) {
            /** @var Operation[] $groupedByWeek */
            foreach ($groupedByWeek as $operation) {
                // group operations by rule
                $groupedByWeekAndRule[$key][$this->getRuleKeyByOperation($operation)][] = $operation;
            }
            yield $groupedByWeekAndRule[$key];
        }
    }

    public function getCalculatedOperations(): Generator
    {
        foreach ($this->getGroupedByWeekAndOperation() as $weekKey => $groupedByWeek) {
            foreach ($groupedByWeek as $operationsForRule) {
                $rule = Rule::create(
                    $this->exchangeRateConvertor,
                    $operationsForRule,
                );

                foreach ($rule->calculate() as $operation) {
                    yield $operation;
                }
            }
        }
    }

    /**
     * Group weeks to work easier with calculations further.
     */
    private function groupByWeeks(): array
    {
        $commissionsGroupedByWeek = [];
        foreach ($this->operations as $operation) {
            $groupByString = $this->getGroupByString($operation);
            $commissionsGroupedByWeek[$groupByString][] = $operation;
        }

        return $commissionsGroupedByWeek;
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
