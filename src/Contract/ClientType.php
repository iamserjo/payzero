<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

interface ClientType
{
    public function __construct(string $typeName);

    public function getTypeName(): string;

    public function getRuleClass(): string;
}
