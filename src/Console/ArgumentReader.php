<?php

declare(strict_types=1);

namespace PayZero\App\Console;

use PayZero\App\Exception\Console\FirstArgumentMissingException;

class ArgumentReader
{
    /**
     * @throws FirstArgumentMissingException
     */
    public function __construct(private readonly array $arguments)
    {
        $this->validateArguments();
    }

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getFirstArgument()
    {
        return $this->arguments[1];
    }

    /**
     * @throws FirstArgumentMissingException
     */
    private function validateArguments(): void
    {
        if (empty($this->arguments[1])) {
            throw new FirstArgumentMissingException('First argument is required');
        }
    }
}
