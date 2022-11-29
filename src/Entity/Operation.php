<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

use PayZero\App\Entity\Client\Type as ClientType;
use PayZero\App\Entity\Operation\Type as OperationType;

class Operation
{
    private \DateTime $date;
    private User $user;
    private ClientType $clientType;
    private OperationType $operationType;
    private float $amount;
    private Currency $currency;

    public function __construct(\DateTime $date,
                                User $user,
                                ClientType $clientType,
                                OperationType $operationType,
                                float $amount,
                                Currency $currency
    ) {
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
