<?php

declare(strict_types=1);

namespace PayZero\App\Entity\Client;

use PayZero\App\Contract\ClientType;
use PayZero\App\Rule\BusinessWithdraw;

class BusinessType implements ClientType
{
    protected string $typeName = '';

    public function setTypeName(string $name): void
    {
        $this->typeName = $name;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getRuleClass(): string
    {
        return BusinessWithdraw::class;
    }
}
