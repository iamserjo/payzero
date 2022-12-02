<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

use PayZero\App\Contract\ClientType;
use PayZero\App\Contract\OperationType;

class Operation
{
    private Commission $commission;

    public function __construct(
        private readonly \DateTimeInterface $date,
        private readonly User $user,
        private readonly ClientType $clientType,
        private readonly OperationType $operationType,
        private readonly string $amount,
        private readonly Currency $currency
    ) {
        $this->commission = new Commission();
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getAmountPrecision(): int
    {
        return strlen(explode('.', $this->amount)[1] ?? '') ?? 0;
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
