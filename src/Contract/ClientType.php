<?php

declare(strict_types=1);

namespace PayZero\App\Contract;

interface ClientType
{
    public function setTypeName(string $name);

    public function getTypeName(): string;

    public function getRuleClass(): string;
}
