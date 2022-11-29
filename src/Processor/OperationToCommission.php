<?php

declare(strict_types=1);

namespace PayZero\App\Processor;

use PayZero\App\Entity\Commission;
use PayZero\App\Entity\Operation;

class OperationToCommission
{
    public const NO_COMMISSION_AMOUNT = 1000;
    public const NO_COMMISSION_TRANSACTIONS = 3;
    /**
     * @var string
     *             2001_13 pattern is flexible to change to
     *             2001 (only year Y) or every month (2001_01 Y_m) or every day (2001_01_30 Y_m_d)
     */
    public const NO_COMMISSION_DATE_PATTERN = 'Y_W';

    /**
     * @see NO_COMMISSION_DATE_PATTERN
     * Pool of dates like weeks
     */
    private array $commissionPool = [];

    /**
     * @param Operation[] $operations
     */
    public function __construct(private readonly array $operations)
    {
        $this->process();
    }

//    public function addOperation(Operation $operation)
//    {
//        $this->operations[] = $operation;
//    }

    /**
     * @return Commission[]
     */
    public function getCalculatedCommissions(): array
    {
        var_dump($this->operations);
        exit;
//        return $this->operations;
    }

    public function process()
    {
        foreach ($this->operations as $operation) {
            var_dump($operation);
            exit;
            if (isset($this->commissionPool[
                $operation->getDate()->format(self::NO_COMMISSION_DATE_PATTERN)
                ])) {
                $this->commissionPool[
                    $operation->getDate()->format(self::NO_COMMISSION_DATE_PATTERN)
                ] = bcadd(
                    $this->commissionPool[
                        $operation->getDate()->format(self::NO_COMMISSION_DATE_PATTERN)
                    ],
                    (string) $operation->getAmount()
                );
            }

            var_dump($this->commissionPool);
            exit;
//            $this->commissionPool[
//                $operation->getDate()->format(self::NO_COMMISSION_DATE_PATTERN)
//            ][] =
        }
    }
}
