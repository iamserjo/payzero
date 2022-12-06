<?php

declare(strict_types=1);

namespace PayZero\App\Entity\Client;

use PayZero\App\Contract\ClientType;
use PayZero\App\Rule\PrivateWithdraw;

class PrivateType implements ClientType
{
    public function __construct(protected string $typeName)
    {
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getRuleClass(): string
    {
        return PrivateWithdraw::class;
    }
}
