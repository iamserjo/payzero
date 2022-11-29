<?php

declare(strict_types=1);

namespace PayZero\App\Entity;

class Currency
{
    public function __construct(private readonly string $currency)
    {
    }
}
