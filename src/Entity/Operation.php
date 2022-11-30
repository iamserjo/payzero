<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

use PayZero\App\Contract\ClientType;
use PayZero\App\Contract\OperationType;

class Operation
{
    private Commission $commission;

    public function __construct(private readonly \DateTimeInterface $date,
                                private User $user,
                                private ClientType $clientType,
                                private OperationType $operationType,
                                private string $amount,
                                private Currency $currency
    ) {
        $this->commission = new Commission();
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getClientType(): ClientType
    {
        return $this->clientType;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getOperationType(): OperationType
    {
        return $this->operationType;
    }

    public function getCommission(): Commission
    {
        return $this->commission;
    }
}
