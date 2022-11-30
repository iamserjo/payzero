<?php

declare(strict_types=1);

namespace PayZero\App\Entity\Client;

use PayZero\App\Contract\ClientType;
use PayZero\App\Rule\PrivateWithdraw;

class PrivateType implements ClientType
{
    protected string $typeName = '';

    public function setTypeName(string $name)
    {
        $this->typeName = $name;
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
