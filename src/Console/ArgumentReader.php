<?php

declare(strict_types=1);

namespace PayZero\App\Console;

class ArgumentReader
{
    public function __construct(private readonly array $arguments)
    {
    }

    public function getFirstArgument(): string
    {
        return $this->arguments[1];
    }
}
